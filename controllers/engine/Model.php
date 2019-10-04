<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 27.09.2019
 * Time: 4:45
 */

namespace app\controllers\engine;

use app\helpers\Db;

class Model
{
    public $connect;
    public $rules;
    public $error = [];
    public $model;

    public function connect()
    {
        $instance = Db::getInstance();
        $this->connect = $instance->getConnection();
    }

    public function validate($model, $id = null)
    {
        foreach ($this->rules as $k => $val){
            foreach($val as $v){
                if($v == 'string'&& isset($model[$k])){
                    if(!is_string($model[$k]))
                        $this->error[$k] = $k." должно быть строкой!";
                }
                if($v == 'integer' && isset($model[$k])){
                    if(iconv_strlen((int)$model[$k]) != iconv_strlen($model[$k]))
                        $this->error[$k] = $k." должно быть целым числом!";
                }
                if($v == 'required'&& isset($model[$k])){
                    if(empty($model[$k]))
                        $this->error[$k] = $k." нужно заполнить!";
                }
                if($v == 'unique'&& isset($model[$k])){
                    $this->connect();
                    $query = "SELECT * FROM ".$this->model." WHERE $k = '".$model[$k]."'";
                    $result = $this->connect->prepare($query);
                    $result->execute();
                    if($result = $result->fetch()){
                        if($result['id'] != $id)
                            $this->error[$k] = $k." должно быть уникальным!";
                    }
                }
                if(is_int($v)&& isset($model[$k])){
                    if(iconv_strlen($model[$k]) > $v)
                        $this->error[$k] = $k." должно содержать $v символов!";
                }
                if($v == 'email'&& isset($model[$k])){
                    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $model[$k]))
                        $this->error[$k] = "Email не валиден!";
                }
            }
        }
        if(count($this->error))
            return false;
        else
            return true;
    }
}