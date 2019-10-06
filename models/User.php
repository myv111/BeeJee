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
    public function getTableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            'username' => ['string', 'required', 255],
            'password' => ['string', 'required', 255],
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function login($model)
    {
        if($this->validate($model)){
            $result = User::find()->where("username = '".$model['username']."' AND password = '".md5($model['password'])."'")->get();
            if(count($result)){
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