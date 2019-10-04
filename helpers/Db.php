<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 26.09.2019
 * Time: 23:54
 */

namespace app\helpers;


use Dotenv\Dotenv;

class Db
{
    private static $instance;
    private $connection;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        $dotenv = Dotenv::create($_SERVER['DOCUMENT_ROOT']);
        $dotenv->load();
        $this->host = getenv('DB_HOST');
        $this->database = getenv('DB_DATABASE');
        $this->user = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8;";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND   => "SET NAMES utf8",
        ];
        $this->connection = new \PDO($dsn, $this->user, $this->password, $opt);

        return $this->connection;
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}