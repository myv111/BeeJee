<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 05.10.2019
 * Time: 18:14
 */

namespace app\controllers\engine\traits;

trait Crud
{

    public function save($model)
    {
        if(!isset($model['id'])){
            $this->connect();

            $query = "INSERT INTO ".$this->model." (";

            foreach($model as $k => $v){
                $query .= $k.', ';
            }
            $query = substr($query, 0, -2).") VALUES (";

            foreach($this->rules as $k => $val){
                if (in_array("string", $val)) {
                    $query .= "'".htmlspecialchars($model[$k])."', ";
                }elseif(isset($model[$k]))
                    $query .= $model[$k].", ";
            }

            $query = substr($query, 0, -2).")";

            if ($this->connect->exec($query))
                return true;
        }else{
            $this->connect();

            $query = "UPDATE ".$this->model." SET ";

            foreach($model as $k => $v){
                if($k != 'id') {
                    $query .= $k . ' = ';
                    if (isset($this->rules[$k])) {
                        if (in_array("string", $this->rules[$k])) {
                            $query .= "'" . htmlspecialchars($model[$k]) . "', ";
                        } else
                            $query .= $model[$k] . ", ";
                    }
                }
            }

            $query = substr($query, 0, -2)." WHERE id = ".$model['id'];

            if ($this->connect->exec($query))
                return true;
        }
        return false;
    }
}