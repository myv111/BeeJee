<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 27.09.2019
 * Time: 0:18
 */

namespace app\models;

use app\controllers\engine\Model;

class Tasks extends Model
{
    public $model = 'tasks';

    public $rules = [
        'username'     => ['string', 'required', 255],
        'email'        => ['email', 'string', 'required', 255],
        'text'         => ['string', 'required'],
        'status'       => ['integer'],
        'admin_update' => ['integer'],
    ];

    public function get()
    {
        $this->connect();
        $query = "SELECT * FROM ".$this->model;

        if(!empty($_SESSION['username']))
            $query .= " ORDER BY username ".$_SESSION['username'];

        if(!empty($_SESSION['email']))
            $query .= " ORDER BY email ".$_SESSION['email'];

        if(!empty($_SESSION['status']))
            $query .= " ORDER BY status ".$_SESSION['status'];

        $start = $_SESSION['page'] * 3;
        $count = $start.", 3";

        $query .= " LIMIT $count";

        $result = $this->connect->query($query);

        return $result;
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

    public function getone($id)
    {
        $this->connect();
        $query = "SELECT * FROM ".$this->model." WHERE id = $id";
        $result = $this->connect->prepare($query);
        $result->execute();

        return $result->fetch();
    }

    public function save($data)
    {
        if($this->validate($data)) {
            $this->connect();
            $username = $data['username'];
            $email = $data['email'];
            $text = htmlspecialchars($data['text'], ENT_QUOTES);
            $query = "INSERT INTO ".$this->model." (username, email, text) 
                                            VALUES ('$username', '$email', '$text')";

            if ($this->connect->exec($query))
                return 1;
        }
        else
            return $this->error;
    }

    public function update($data, $model)
    {
        if($this->validate($data, $model['id'])) {
            $this->connect();

            $username = $data['username'];
            $email = $data['email'];
            $text = htmlspecialchars($data['text'], ENT_QUOTES);

            $status = 0;
            if(isset($data['status']))
                $status = 1;

            $admin_update = 0;
            if($model['text'] != $text || $model['admin_update'] != 0)
                $admin_update = 1;

            $query = "UPDATE ".$this->model." SET username = '$username', email = '$email'
            , text = '$text', status = $status, admin_update = $admin_update WHERE id = ".$model['id'];

            if ($this->connect->exec($query))
                return 1;
        }
        else
            return $this->error;
    }
}