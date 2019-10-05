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
    public $limit = 4;

    public function getTableName()
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            'username'     => ['string', 'required', 255],
            'email'        => ['email', 'string', 'required', 255],
            'text'         => ['string', 'required'],
            'status'       => ['integer'],
            'admin_update' => ['integer'],
        ];
    }
}