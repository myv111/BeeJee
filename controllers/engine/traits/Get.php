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
    public function getone($id)
    {
        $this->connect();
        $query = "SELECT * FROM ".$this->model." WHERE id = $id";
        $result = $this->connect->prepare($query);
        $result->execute();

        return $result->fetch();
    }

    public function getAll()
    {
        $this->connect();
        $query = "SELECT count(*) FROM ".$this->model;

        $result = $this->connect->prepare($query);
        $result->execute();
        $number_of_rows = $result->fetchColumn();

        return $number_of_rows;
    }

    public function get($order_by = null, $limit = null)
    {
        $this->connect();
        $query = "SELECT * FROM ".$this->model;

        if($order_by)
            $query .= " ORDER BY $order_by";

        if($limit){
            $limit = $limit - 1;
            $start = $limit * $this->limit;
            $count = $start.", ".$this->limit;

            $query .= " LIMIT $count";
        }

        $result = $this->connect->query($query);

        return $result;
    }
}