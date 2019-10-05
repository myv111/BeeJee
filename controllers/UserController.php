<?php
namespace app\controllers;

use app\controllers\engine\Controller;
use app\models\User;

class UserController extends Controller
{
    public function Login()
    {
        if($_SESSION['admin'] == 1)
            header("Location: /");
        if(isset($_POST['username'])){
            $user = new User();
            $result = $user->login($_POST);

            $array = [];
            if($result == 1){
                $array['success'] = 1;
                echo json_encode($array);
            }else{
                if(!$result)
                    $result['login'] = "<div style='margin-bottom:5px;'>Логин или пароль не верные!</div>";
                $result['success'] = 0;
                echo json_encode($result);
            }
            die;
        }

        $this->view('login');
    }

    public function Logout()
    {
        $user = new User();
        $user->logout();
        header("Location: /");
    }
}
