<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 27.09.2019
 * Time: 0:43
 */

namespace app\controllers\engine;

class Controller
{
    public function view($view, $params = null, $model = null)
    {
        $content = "views/$view.php";
        require_once "views/layouts/main.php";
    }

    public function viewAjax($view, $params = null)
    {
        require_once "views/$view.php";
    }
}