<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 26.09.2019
 * Time: 17:31
 */
namespace app\helpers;

use app\controllers\SiteController;

class Router
{
    private $route;

    public function __construct()
    {
        $this->route = explode('/', substr($_SERVER['REQUEST_URI'], 1));
    }

    public function run()
    {
        if(empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/'){
            $class = new SiteController();
            $class->Index();
            return;
        }

        $route = mb_convert_case($this->route[0], MB_CASE_TITLE, 'UTF-8');
        $route = '\app\controllers\\'.$route.'Controller';
        if(!class_exists($route)) {
            echo 'Такой страницы не существует!';
            return;
        }
        else{
            $class = new $route();
        }

        if(!isset($this->route[1]))
            $class->Index();
        else{
            $model = mb_convert_case($this->route[1], MB_CASE_TITLE, 'UTF-8');
            if(!method_exists($class, $model))
                echo 'Такой страницы не существует!';
            else{
                $class->$model();
            }
        }

    }
}