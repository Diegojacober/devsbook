<?php

namespace src\models;

use \core\Model;

class User extends Model
{

    public $id;
    public $nome;
    public $avatar;
    public $email;
    public $birthdate;
    public $city;
    public $work;
    public $cover;
    public $followers;
    public $following;
    public $photos;
    public $years;
    


    public function __set($name, $valor)
    {
    }
}
