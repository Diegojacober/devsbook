<?php

namespace src\controllers;

use \core\Controller;
use src\handlers\UserHandler;

class LoginController extends Controller
{

    public function signin()
    {
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('login', ['flash' => $flash]);
    }


    public function signup()
    {
        $flash = $_SESSION['flash'];
        if (!empty($_SESSION['flash'])) {

            $_SESSION['flash'] = '';
        }
        $this->render('/signup', ['flash' => $flash]);
    }

    public function signinAction()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if ($email && $password) {
            $token = UserHandler::verifyLogin($email, $password);
            if ($token) {
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {
                $_SESSION['flash'] = 'E-mail e/ou senha incorretos';
                $this->redirect('/login');
            }
        } else {
            $_SESSION['flash'] = 'Digite os campos de e-mail e/ou senha.';
            $this->redirect('/login');
        }
    }

    public function signupaction()
    {
        $nome = filter_input(INPUT_POST, 'nome');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $pass = filter_input(INPUT_POST, 'password');
        $birthdate = filter_input(INPUT_POST, 'data');
        
       
        if ($nome && $email && $pass && $birthdate) {
    
            $birthdate = explode('/', $birthdate);
           
            if(count($birthdate) != 3)
            {
                $_SESSION['flash'] = 'Data de nascimento inválida';
                $this->redirect('/cadastro');
            }
 
            //calcular idade para menor que 16
            $birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];
            $birthdate = new \DateTime($birthdate);
            $dateTo = new \DateTime('today');
            $dif = $birthdate->diff($dateTo)->y;
            
            if($dif < 15 || $_SESSION['idade'] == 'menor_que_15')
            {
                $_SESSION['flash'] = 'Para se cadastrar é necessário ter no minimo 15 anos';
                $_SESSION['idade'] = 'menor_que_15';
                $this->redirect('/cadastro');
            }      
            

            if (UserHandler::emailExists($email) === false) {
                $token = UserHandler::addUser($nome, $email, $pass, $birthdate);
                $_SESSION['token'] = $token;
                $this->redirect('/');
                echo 'Cadastrando';
            } else {
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/cadastro');
            }
         } else {
            $this->redirect('/cadastro');
        }
    }
    public function logout()
    {
        $_SESSION['token'] = '';
        $this->redirect('/login');
    }
}
