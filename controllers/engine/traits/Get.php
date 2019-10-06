<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 05.10.2019
 * Time: 18:19
 */

namespace app\controllers\engine\traits;

trait Get
{
    private static $instance;

    public static function find()
    {
        if(!self::$instance){
            $class = get_called_class();
            self::$instance = new $class();
        }

        return self::$instance;
    }

    public function getone($id)
    {
        $this->connect();
        $query = "SELECT * FROM ".$this->model." WHERE id = $id";
        $result = $this->connect->prepare($query);
        $result->execute();

        foreach ($result as $val){
            foreach ($val as $k => $v) {
                $this->addProperty($k, $v);
            }
        }

        return $this;
    }

    public function getCountAll()
    {
        $this->connect();
        $query = "SELECT count(*) FROM ".$this->model;

        $result = $this->connect->prepare($query);
        $result->execute();
        $number_of_rows = $result->fetchColumn();

        return $number_of_rows;
    }

    public function where($query)
    {
        $this->query .= ' WHERE '.$query;
        return $this;
    }

    public function orderBy($order_by)
    {
        $this->query .= " ORDER BY $order_by";
        return $this;
    }

    public function limit($limit)
    {
        $this->query .= " LIMIT $limit";
        return $this;
    }


    public function get()
    {
        $this->connect();
        $result = $this->connect->query($this->query);

        $array = [];

        foreach ($result as $k => $val){
            $class = get_called_class();
            $model = new $class();
            foreach ($val as $k => $v) {
                $model->addProperty($k, $v);
            }
            $array[] = $model;
        }

        return $array;
    }

    public function addProperty($propertyName, $value)
    {
        $this->{$propertyName} = $value;
    }

    public function addPropertyArray($propertyName, $value)
    {
        $this->{$propertyName} = $value;
    }
}