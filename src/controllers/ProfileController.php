<?php

namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;


class ProfileController extends Controller
{

    private $loggedUser;

    public function __construct()
    {
        $loggedUser = UserHandler::checkLogin();
        if ($loggedUser === false) {
            return $this->redirect('/login');
        }
        $this->loggedUser = $loggedUser;
    }

    public function index($atts = [])
    {
        $page = intval(filter_input(INPUT_GET,'page'));

        
        $id = $this->loggedUser->id;
        if(!empty($atts['id']))
        {
            $id = $atts['id'];
        }

        $user = UserHandler::getUser($id,true);

        if(!$user){
            $this->redirect('/');
        }

        $dateFrom = new DateTime($user->birthdate);
        $dateTo = new DateTime('today');
        $user->years = $dateFrom->diff($dateTo)->y;

        

        $feed = PostHandler::getUserFeed($id,$page,$this->loggedUser->id);


        //Verificando se está seguindo
        $isfollowing = false;
        if($user->id != $this->loggedUser->id)
        {
            $isfollowing = UserHandler::isFollowing($this->loggedUser->id,$user->id);

        }
        
        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isfollowing
        ]);

    }

    public function follow($atts)
    {
       $to = intval($atts['id']);

       $exists = UserHandler::idExists($to);

        if($exists)
        {
            if(UserHandler::isFollowing($this->loggedUser->id,$to))
            {
                //deixar de seguir
                UserHandler::unfollow($this->loggedUser->id,$to);
            }
            else{
                //seguir
                UserHandler::follow($this->loggedUser->id,$to);
            }
        }
        $this->redirect('/perfil/'.$to);
    }

    public function friends($attrs = [])
    {
        $id = $this->loggedUser->id;
        if(!empty($attrs['id']))
        {
            $id = $attrs['id'];
        }

        $user = UserHandler::getUser($id,true);

        if(!$user){
            $this->redirect('/');
        }

        $dateFrom = new DateTime($user->birthdate);
        $dateTo = new DateTime('today');
        $user->years = $dateFrom->diff($dateTo)->y;

        $isfollowing = false;
        if($user->id != $this->loggedUser->id)
        {
            $isfollowing = UserHandler::isFollowing($this->loggedUser->id,$user->id);

        }

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isfollowing
        ]);

    }

    public function photos($attrs = [])
    {
        $id = $this->loggedUser->id;
        if(!empty($attrs['id']))
        {
            $id = $attrs['id'];
        }

        $user = UserHandler::getUser($id,true);

        if(!$user){
            $this->redirect('/');
        }

        $dateFrom = new DateTime($user->birthdate);
        $dateTo = new DateTime('today');
        $user->years = $dateFrom->diff($dateTo)->y;

        $isfollowing = false;
        if($user->id != $this->loggedUser->id)
        {
            $isfollowing = UserHandler::isFollowing($this->loggedUser->id,$user->id);

        }

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isfollowing
        ]);

    }

    

    
}
