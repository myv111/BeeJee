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
    public $layouts = 'main';

    public function view($view, $params = null, $model = null)
    {
        $content = $this->content($view);
        require_once "views/layouts/$this->layouts.php";
    }

    public function viewAjax($view, $params = null)
    {
        $content = $this->content($view);
        require_once $content;
    }

    public function content($view)
    {
        $view_dir = $view;
        if(!$this->view_dir_isset($view)){
            $view_dir = $this->view_dir();
            return "views/$view_dir/$view.php";
        }else
            return "views/$view.php";
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