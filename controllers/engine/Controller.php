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
    use \app\controllers\engine\traits\Controller;

    public $layouts = 'main';

    public function view($view, $params = null, $model = null)
    {
        ob_start();
        $this->content($view, $params, $model);
        $content = ob_get_contents();
        ob_end_clean();
        require_once "views/layouts/$this->layouts.php";

    }

    public function viewAjax($view, $params = null)
    {
        $this->content($view, $params);
    }

    public function renderView($view)
    {
        return require_once "views/layouts/$view.php";
    }
}