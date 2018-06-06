<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 05.06.2018
 * Time: 2:40
 */

namespace app\controllers;


use vendor\core\utility\Logger;
use vendor\core\Db;

use vendor\core\QueryBuilder;

class AdminController extends AppController
{
    public function indexAction(){
        $data = $_POST;
        $columns =[];
        $entities = [];
        $table=[];
        if(isset($data["sub_btn"])){
            $table =  $data["selection"];
            $resultSetColumns = Db::instance()->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'shoeshop' AND TABLE_NAME = '{$table}'");
            foreach ($resultSetColumns as $item) {
                array_push($columns,$item["COLUMN_NAME"]);
            }
            $entities = QueryBuilder::table($table)->get();
        }
        $this->set(["table"=>$table,"columns"=>$columns,"entities"=>$entities]);
    }

    public function editAction(){
        $data = $_POST;
//
//        $str="";
//
//        foreach ($data as $key=>$item) {
//            $str.="[{$key}|{$item}]";
//        }
//        Logger::message($str);


        if(isset($data['save'])){
            $table = trim($data['table']);

            $columlList = " (";
            $valuelList = " (";
            foreach ($data as $column => $value) {
                if($column=="table"||$column=="id"||$column=="save"){
                    continue;
                }
                $columlList .= "{$column} , ";
                $valuelList .= "'{$value}' , ";
            }
            $columlList = str_last_replace(", ", ")", $columlList);
            $valuelList = str_last_replace(", ", ")", $valuelList);
            $sqlQuery = "INSERT INTO " . $table . $columlList . " VALUES" . $valuelList;
            Logger::message($sqlQuery);


            Db::instance()->execute($sqlQuery,$this->attributes);
        }


        if(isset($data['delete'])){
            $table = trim($data['table']);
            $id = $data['id'];

            $sqlQuery = "DELETE FROM ".$table." WHERE id = ".$id;
            Logger::message($sqlQuery);
            Db::instance()->execute($sqlQuery);
        }
        if(isset($data['edit'])){

            $table = trim($data['table']);
            $id = $data['id'];
            $entity = QueryBuilder::table($table)->where('id','=',$id)->first();

            foreach ($entity as $key=>$value){
                $entity[$key] = $data[$key];
            }

            $fieldsList = " SET ";
            foreach ($entity as $column => $value) {
                $fieldsList.=$column."=".'\''.$data[$column].'\''.", ";
            }
            $fieldsList = str_last_replace(", ", "", $fieldsList);
            $sqlQuery = "UPDATE ".$table.$fieldsList." WHERE ".'id'." = ".$id;

            Logger::message($sqlQuery);
            Db::instance()->execute($sqlQuery);
        }
        header("Location: /admin");
    }
}