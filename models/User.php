<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 27.09.2019
 * Time: 0:18
 */

namespace app\models;

use app\controllers\engine\Model;

class User extends Model
{
    public $model = 'user';

    public $rules = [
        'username' => ['string', 'required', 255],
        'password' => ['string', 'required', 255],
    ];

    public function login($model)
    {
        if($this->validate($model)){
            $this->connect();
            $query = "SELECT * FROM ".$this->model." WHERE username = '".$model['username']."' AND password = '".md5($model['password'])."'";

            $result = $this->connect->query($query);
            if($result->fetchColumn()){
                $_SESSION['admin'] = 1;
                return true;
            }
        }else{
            return $this->error;
        }
    }

    public function logout()
    {
        $_SESSION['admin'] = 0;
    }
}