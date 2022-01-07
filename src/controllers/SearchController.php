<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class SearchController extends Controller {

    private $loggedUser;

    public function __construct()
    {
        $loggedUser = UserHandler::checkLogin();
        if($loggedUser === false){
            return $this->redirect('/login');
        }
        $this->loggedUser = $loggedUser;
        
    }

    public function index(){
        $searchTerm = filter_input(INPUT_GET,'s');

        if(empty($searchTerm))
        {
            $this->redirect('/');
        }

        $users = UserHandler::searchUser($searchTerm);

        $this->render('search', [
            'loggedUser' => $this->loggedUser,
            'searchTerm' => $searchTerm,
            'users' => $users
        ]);

    }


}