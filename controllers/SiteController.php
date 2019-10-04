<?php
namespace app\controllers;

use app\controllers\engine\Controller;
use app\models\Tasks;
use app\models\User;

class SiteController extends Controller
{
    public function __construct()
    {
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
            $_SESSION['page'] = $_GET['page'] - 1;
        }else{
            $_SESSION['page'] = 0;
        }

        $tasks = $task->get();
        $_SESSION['counttasks'] = $task->getAll();

        $this->view('index', $tasks, $task);
    }

    public function Addtask()
    {
        if(isset($_POST['username'])){
            $task = new Tasks();
            $result = $task->save($_POST);

            $array = [];
            if($result == 1){
                $array['success'] = 1;
                echo json_encode($array);
            }else{
                $result['success'] = 0;
                echo json_encode($result);
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

        $task_model = new Tasks();

        if(isset($_GET['id']))
            $task = $task_model->getone($_GET['id']);
        else
            $task = $task_model->getone($_POST['id']);

        if(isset($_POST['username'])){
            $result = $task_model->update($_POST, $task);

            $array = [];
            if($result == 1){
                $array['success'] = 2;
                echo json_encode($array);
            }else{
                $result['success'] = 0;
                echo json_encode($result);
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

            $task = new Tasks();
            $params = $task->get();

            foreach($params as $v){
                $status = 'выполняется';
                if($v['status'] == 1)
                    $status = 'выполнено';

                $admin_update = '';
                if($v['admin_update'] == 1)
                    $admin_update = 'отредактировано администратором';

                if($_SESSION['admin']) {
                    echo '<div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-2">' . $v['username'] . '</div>
                                <div class="col-xl-2">' . $v['email'] . '</div>
                                <div class="col-xl-4">' . $v['text'] . '</div>
                                <div class="col-xl-2">
                                    ' . $status . '
                                    <br />
                                    ' . $admin_update . '
                                </div>
                                <div class="col-xl-2 update"><a class="btn edit" href="/site/updatetask/?id=' . $v['id'] . '">Редактировать</a></div>
                            </div>
                          </div>';
                }else{
                    echo '<div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-3">' . $v['username'] . '</div>
                                <div class="col-xl-3">' . $v['email'] . '</div>
                                <div class="col-xl-4">' . $v['text'] . '</div>
                                <div class="col-xl-2">
                                    ' . $status . '
                                    <br />
                                    ' . $admin_update . '
                                </div>
                            </div>
                          </div>';
                }
            }
            die;
        }
    }
}
