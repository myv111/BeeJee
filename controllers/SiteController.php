<?php
namespace app\controllers;

use app\controllers\engine\Controller;
use app\models\Tasks;
use app\models\User;

class SiteController extends Controller
{
    public function __construct()
    {
        if(!isset($_SESSION['admin']))
            $_SESSION['admin'] = 0;

        if(!isset($_SESSION['username']))
            $_SESSION['username'] = '';

        if(!isset($_SESSION['email']))
            $_SESSION['email'] = '';

        if(!isset($_SESSION['status']))
            $_SESSION['status'] = '';


        if(!isset($_SESSION['counttasks']))
            $_SESSION['counttasks'] = '';
    }

    public function Index()
    {
        $task = new Tasks();

        if(isset($_GET['page'])){
            $_SESSION['page'] = $_GET['page'];
        }else{
            $_SESSION['page'] = 1;
        }

        if(!empty($_SESSION['username']))
            $order_by = 'username '.$_SESSION['username'];

        if(!empty($_SESSION['email']))
            $order_by = 'email '.$_SESSION['email'];

        if(!empty($_SESSION['status']))
            $order_by = 'status '.$_SESSION['status'];

        $tasks = $task->get($order_by, $_SESSION['page']);
        $_SESSION['counttasks'] = $task->getAll();

        $this->view('index', $tasks, $task);
    }

    public function Addtask()
    {
        if(isset($_POST['username'])){
            $task = new Tasks();

            if($task->validate($_POST) && $task->save($_POST)) {
                $array = [];
                $array['success'] = 1;
                echo json_encode($array);
            }else{
                $task->error['success'] = 0;
                echo json_encode($task->error);
            }
            die;
        }

        $this->view('add-edit-task');
    }

    public function Updatetask()
    {
        if($_SESSION['admin'] == 0){
            if(!$_POST['username'])
                header("Location: /user/login");
            else{
                $array['success'] = 3;
                echo json_encode($array);
                die;
            }
        }

        $model = new Tasks;

        if(isset($_GET['id']))
            $task = $model->getone($_GET['id']);
        else
            $task = $model->getone($_POST['id']);

        if(isset($_POST['username'])){
            if($model->validate($_POST) && $model->save($_POST)){
                $array = [];
                $array['success'] = 2;
                echo json_encode($array);
            }else{
                $model->error['success'] = 0;
                echo json_encode($model->error);
            }
            die;
        }

        $this->view('add-edit-task', $task);
    }

    public function Sort()
    {
        if($_POST['sort']){
            if($_POST['sort'] != 'username')
                $_SESSION['username'] = '';

            if($_POST['sort'] != 'email')
                $_SESSION['email'] = '';

            if($_POST['sort'] != 'status')
                $_SESSION['status'] = '';

            if($_SESSION[$_POST['sort']] == 'DESC')
                $_SESSION[$_POST['sort']] = 'ASC';
            else
                $_SESSION[$_POST['sort']] = 'DESC';

            $order_by = $_POST['sort'].' '.$_SESSION[$_POST['sort']];

            $task = new Tasks();

            $params = $task->get($order_by, $_SESSION['page']);

            $this->viewAjax('main-sort', $params);

            die;
        }
    }
}
