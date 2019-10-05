<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 27.09.2019
 * Time: 4:45
 */

namespace app\controllers\engine;

use app\controllers\engine\traits\Crud;
use app\controllers\engine\traits\Get;
use app\helpers\Db;

abstract class Model
{
    use Crud;
    use Get;

    public $connect;
    public $rules;
    public $error = [];
    public $model;
    public $limit;
    public $attributes;

    public function __construct()
    {
        $this->model = $this->getTableName();
        $this->rules = $this->rules();
        $this->attributes = $this->attributes();
    }

    public abstract function getTableName();

    public abstract function rules();

    public abstract function attributes();

    public function connect()
    {
        $instance = Db::getInstance();
        $this->connect = $instance->getConnection();
    }

    public function validate($model, $id = null)
    {
        foreach ($this->rules as $k => $val){
            foreach($val as $v){
                if($v == 'integer' && isset($model[$k])){
                    if(iconv_strlen((int)$model[$k]) != iconv_strlen($model[$k])){
                        if(isset($this->attributes[$k]))
                            $this->error[$k] = $this->attributes[$k]." должно быть целым числом!";
                        else
                            $this->error[$k] = $k." должно быть целым числом!";
                    }
                }
                if($v == 'required'&& isset($model[$k])){
                    if(empty($model[$k])){
                        if(isset($this->attributes[$k]))
                            $this->error[$k] = $this->attributes[$k]." нужно заполнить!";
                        else
                            $this->error[$k] = $k." нужно заполнить!";
                    }

                }
                if($v == 'unique'&& isset($model[$k])){
                    $this->connect();
                    $query = "SELECT * FROM ".$this->model." WHERE $k = '".$model[$k]."'";
                    $result = $this->connect->prepare($query);
                    $result->execute();
                    if($result = $result->fetch()){
                        if($result['id'] != $id){
                            if(isset($this->attributes[$k]))
                                $this->error[$k] = $this->attributes[$k]." должно быть уникальным!";
                            else
                                $this->error[$k] = $k." должно быть уникальным!";
                        }
                    }
                }
                if(is_int($v)&& isset($model[$k])){
                    if(iconv_strlen($model[$k]) > $v){
                        if(isset($this->attributes[$k]))
                            $this->error[$k] = $this->attributes[$k]." должно содержать $v символов!";
                        else
                            $this->error[$k] = $k." должно содержать $v символов!";
                    }
                }
                if($v == 'email'&& isset($model[$k])){
                    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $model[$k])){
                        if(isset($this->attributes[$k]))
                            $this->error[$k] = $this->attributes[$k]." не валиден!";
                        else
                            $this->error[$k] = $k." не валиден!";
                    }
                }
            }
        }
        if(count($this->error))
            return false;
        else
            return true;
    }
}