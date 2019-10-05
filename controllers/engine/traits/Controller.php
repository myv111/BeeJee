<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 05.10.2019
 * Time: 23:18
 */

namespace app\controllers\engine\traits;


trait Controller
{
    public function content($view, $params = null, $model = null)
    {
        $view_dir = $view;
        if(!$this->view_dir_isset($view)){
            $view_dir = $this->view_dir();
            return require_once "views/$view_dir/$view.php";
        }else
            return require_once "views/$view.php";
    }

    public function view_dir()
    {
        $pattern = "/(.+)\\\(\w+)(Controller)$/i";
        $replacement = '${2}';
        $view_dir =  preg_replace($pattern, $replacement, get_class($this));
        return mb_strtolower($view_dir);
    }

    public function view_dir_isset($view)
    {
        $pattern = '/\//';
        if(preg_match($pattern, $view, $matches))
            return true;
        else
            return false;
    }
}