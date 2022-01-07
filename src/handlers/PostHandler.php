<?php

namespace src\handlers;

use src\models\Post;
use src\models\User;
use src\models\PostLike;
use src\models\PostComment;
use src\models\UserRelation;

class PostHandler
{

    public static function addPost($idUser, $type, $body)
    {
        $body = trim($body);

        if (!empty($idUser) && !empty($body)) {
            date_default_timezone_set('America/Sao_Paulo');
            Post::insert([
                'id_author' => $idUser,
                'typ' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'body' => $body

            ])->execute();
        }
    }

    public static function _postListToObject($postList, $loggedUserId)
    {
        $posts = [];
        foreach ($postList as $postItem) {
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->type = $postItem['typ'];
            $newPost->created_at = $postItem['created_at'];
            $newPost->body = $postItem['body'];
            $newPost->mine = false;

            if ($postItem['id_author'] === $loggedUserId) {
                $newPost->mine = true;
            }

            //4 . informações adicionais no post
            $newUser = User::select()->where('id', $postItem['id_author'])->one();
            $newPost->user = new User();
            $newPost->user->id = $newUser['id'];
            $newPost->user->nome = $newUser['nome'];
            $newPost->user->email = $newUser['email'];
            $newPost->user->avatar = $newUser['avatar'];


            //4.1 preencher informações de like
            $likes = PostLike::select()->where('id_post', $postItem['id'])->get();

            $newPost->likeCount = count($likes);
            $newPost->liked = self::isLiked($postItem['id'], $loggedUserId);

            //4.2 preencher informações de comentários
            $newPost->comments = PostComment::select()->where('id_post', $postItem['id'])->get();

            foreach ($newPost->comments as $key => $comment) {
                $newPost->comments[$key]['user'] = User::select()->where('id', $comment['id_user'])->one();
            }

            $posts[] = $newPost;
        }
        return $posts;
    }

    public static function isLiked($id, $loggedUserId)
    {
        $myLike = PostLike::select()
            ->where('id_post', $id)
            ->where('id_user', $loggedUserId)
            ->get();

        if (count($myLike) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteLike($id, $loggedUser)
    {
        Postlike::delete()->where('id_post', $id)->where('id_user', $loggedUser)->execute();
    }

    public static function addLike($id, $loggedUser)
    {
        Postlike::insert([
            'id_post' => $id,
            'id_user' => $loggedUser
        ])->execute();
    }

    public static function addComment($id, $txt, $loggedUser)
    {
        PostComment::insert([
            'id_post' => $id,
            'id_user' => $loggedUser,
            'body' => $txt
        ])->execute();
    }

    public static function getUserFeed($id, $page, $loggedUserId)
    {
        $perPage = 20;
        //2 . Pegar os posts ordenados por data
        $postList = Post::select()
            ->where('id_author', $id)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        $total = Post::select()
            ->where('id_author', $id)
            ->count();

        $pageCount = ceil($total / $perPage);



        //3 . transformar os resultados em objetos dos models
        $posts = self::_postListToObject($postList, $loggedUserId);
        //5 . retornar o resultado com os posts
        return [
            'posts' => $posts,
            'pageCount' => $pageCount,
            'currentPage' => $page
        ];
    }



    public static function getHomeFeed($idUser, $page)
    {

        $perPage = 25;
        //1 . Pegar lista de usuários que são seguidos
        $users_list = UserRelation::select()->where('user_from', $idUser)->get();
        $users = [];
        foreach ($users_list as $user_item) {
            $users[] = $user_item['user_to'];
        }
        $users[] = $idUser;


        //2 . Pegar os posts ordenados por data
        $postList = Post::select()
            ->where('id_author', 'in', $users)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        $total = Post::select()
            ->where('id_author', 'in', $users)
            ->count();

        $pageCount = ceil($total / $perPage);



        //3 . transformar os resultados em objetos dos models
        $posts = self::_postListToObject($postList, $idUser);
        //5 . retornar o resultado com os posts
        return [
            'posts' => $posts,
            'pageCount' => $pageCount,
            'currentPage' => $page
        ];
    }

    public static function getPhotosFrom($id)
    {
        $photosData = Post::select()
            ->where('id_author', $id)
            ->where('typ', 'photo')
            ->get();

        $photos = [];

        foreach ($photosData as $photo) {
            $newPost = new Post();
            $newPost->id = $photo['id'];
            $newPost->typ = 'photo';
            $newPost->created_at = $photo['created_at'];
            $newPost->body = $photo['body'];

            $photos[] = $newPost;
        }
        return $photos;
    }


    public static function delete($id, $loggedUserId)
    {

        //verificar se o post existe e se é do usuario logado
        $post = Post::select()->where('id', $id)->where('id_author', $loggedUserId)->get();

        if (count($post) > 0) {
            $post = $post[0];

            //deleter curtidas e comentários
            PostLike::delete()->where('id_post', $id)->execute();
            PostComment::delete()->where('id_post', $id)->execute();

            // se for uma foto deletar arquivo
            if($post['typ'] === 'photo')
            {
                
                $img = __DIR__.'/../../public/media/uploads/'.$post['body'];
                if(file_exists($img))
                {
                    unlink($img);
                }
            }

            Post::delete()->where('id',$id)->execute();
        }




        //deletar post
    }
}
