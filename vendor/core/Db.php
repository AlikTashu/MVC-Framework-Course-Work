<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 22.04.2018
 * Time: 22:18
 */

namespace vendor\core;


class Db
{
    protected $pdo;
    protected static $instance;

    public static $countSql;
    public static $queries=[];

    public function getLastInsertId(){
        return $this->pdo->lastInsertId("id");
    }

    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $db['options']);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function execute($sql,$params = []){
        self::$countSql++;
        self::$queries[] = $sql;
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($params);
    }

    public function query($sql,$params = []){
        self::$countSql++;
        self::$queries[] = $sql;
        $statement = $this->pdo->prepare($sql);
        $res =  $statement->execute($params);
        if($res!== false) {
            return $statement->fetchAll();
        }
        return [];
    }


    public static function DebugSQL($sql,$placeholders)
    {
        foreach ($placeholders as $k => $v) {
            $sql = preg_replace('/:' . $k . '/', "'" . $v . "'", $sql);
        }
        return $sql;
    }


}