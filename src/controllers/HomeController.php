<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;


class HomeController extends Controller
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

    public function index()
    {
        $page = intval(filter_input(INPUT_GET,'page'));


        $feed = PostHandler::getHomeFeed(
            $this->loggedUser->id,
            $page
        );
        //ou  getUserFeed($id)

        $this->render(
            'home',
            [
                'loggedUser' => $this->loggedUser,
                'feed' => $feed

            ]);
    }

    
}
