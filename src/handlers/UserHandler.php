<?php

namespace src\handlers;

use src\models\User;
use src\models\UserRelation;
use src\handlers\PostHandler;

class UserHandler
{

    public static function checkLogin()
    {


        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $data = User::select()->where('token', $token)->one();
            if (!empty($data)) {
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->email = $data['email'];
                $loggedUser->nome = $data['nome'];
                $loggedUser->avatar = $data['avatar'];


                return $loggedUser;
            }
        }
        return false;
    }

    public static function verifyLogin($email, $password)
    {
        $user = User::select()->where('email', $email)->one();
        if ($user) {
            if (password_verify($password, $user['pass'])) {
                $token = md5(time() . rand(0, 9999) . time());

                User::update()
                    ->set('token', $token)
                    ->where('email', $email)
                    ->execute();

                return $token;
            }
        } else {
            return false;
        }
    }

    public static function idExists($id)
    {
        $user = User::select()->where('id', $id)->one();
        return $user ? true : false;
    }

    public static function emailExists($email)
    {
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    public static function follow($from, $to)
    {
        UserRelation::insert([
            'user_from' => $from,
            'user_to' => $to
        ])->execute();
    }

    public static function unfollow($from, $to)
    {
        UserRelation::delete()->where('user_from', $from)->where('user_to', $to)->execute();
    }

    public static function getUser($id, $full = false)
    {
        $data = User::select()->where('id', $id)->one();

        if ($data) {
            $user = new User();
            $user->id = $data['id'];
            $user->nome = $data['nome'];
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->avatar = $data['avatar'];
            $user->cover = $data['cover'];
            $user->email = $data['email'];

            if ($full) {
                $user->followers = [];
                $user->following = [];
                $user->photos = [];

                //followers
                $followers = UserRelation::select()->where('user_to', $id)->get();

                foreach ($followers as $follower) {
                    $userData = User::select()->where('id', $follower['user_from'])->one();
                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->nome = $userData['nome'];
                    $newUser->avatar = $userData['avatar'];
                    $newUser->cover = $userData['cover'];

                    $user->followers[] = $newUser;
                }

                //following
                $following = UserRelation::select()->where('user_from', $id)->get();

                foreach ($following as $follower) {
                    $userData = User::select()->where('id', $follower['user_to'])->one();
                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->nome = $userData['nome'];
                    $newUser->avatar = $userData['avatar'];
                    $newUser->cover = $userData['cover'];

                    $user->following[] = $newUser;
                }

                //photos
                $user->photos = PostHandler::getPhotosFrom($id);
            }
            return $user;
        } else {
            return false;
        }
    }

    public static function isFollowing($from, $to)
    {
        $data = UserRelation::select()->where('user_from', $from)->where('user_to', $to)->one();

        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public static function searchUser($term)
    {
        $users = [];
        $data = User::select()->where('nome', 'like', '%'. $term .'%')->get();

        if ($data) {
            foreach ($data as $user) {
                $newUser = new User;
                $newUser->id = $user['id'];
                $newUser->nome = $user['nome'];
                $newUser->avatar = $user['avatar'];
                $newUser->cover = $user['cover'];

                $users[] = $newUser; 
            }
        }

        return $users;
    }


    public  static function addUser($name, $email, $password, $birthdate)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time() . rand(0, 9999) . time());
        User::insert([
            'nome' => $name,
            'email' => $email,
            'pass' => $hash,
            'birthdate' => $birthdate,
            'token' => $token,
            'avatar' => 'avatar.jpg',
            'cover' => 'cover.jpg',
            'work' => '',
            'city' => ''
        ])->execute();

        return $token;
    }

    public static function updateUser($id, $name, $email, $birthdate, $city, $work,$avatar,$cover) {
        $user = User::select()->where('id', $id)->one();
                
        if($user){
            User::update()
                ->set('nome', $name)
                ->set('email', $email)
                ->set('birthdate', $birthdate)
                ->set('city', $city)
                ->set('work', $work)
                ->set('avatar',$avatar)
                ->set('cover',$cover)
                ->where('id', $id)
            ->execute();
        }
    }
    public static function updatePassword($id, $password) {
        $user = User::select()->where('id', $id)->one();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if($hash){
            User::update()
                ->set('pass', $hash)
                ->where('id', $id)
            ->execute();
        }
    }
}
