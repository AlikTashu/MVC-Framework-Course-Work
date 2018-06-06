<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 22.04.2018
 * Time: 22:19
 */

namespace vendor\core\base;

use vendor\core\Db;
use vendor\core\QueryBuilder;

abstract class Model
{

    protected $table;
    protected $idName = "id";
    protected $isAutoInc = true;
    protected $isNew = false;
    protected $sql;
    protected $attributes = [];


    public function __construct($attr = null, $isNew = false)
    {
        $this->setTable();
        $this->isNew = $isNew;
        $this->sql = QueryBuilder::table($this->table);
        if (isset($attr) && is_assoc_array($attr)) {
            $this->attributes = $attr;
        }
    }

    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
    }

    public function __set($name, $value)
    {
        #if (isset($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        #}
    }

    public function __call($name, $arguments)
    {
        if($name === "first"||$name === "get"){
            $res = call_user_func_array(array($this, $name), $arguments);
            return $res;
        }
        $res = call_user_func_array(array($this->sql, $name), $arguments);
        return $this;

    }

    public static function __callStatic($name, $arguments)
    {
        $model = new static();
        return call_user_func_array(array($model, $name), $arguments);
    }

    public function save(){
        if($this->isNew){
            $this->insert();
        }
        else{
            $this->update();
        }
    }

    private function first(){
        $result = $this->sql->first();
        $model = new static($result);
        return $model;
    }

    private function get()
    {
        $models = [];
        $result = $this->sql->get();
        foreach ($result as $record) {
            $models[] = new static($record);
        }
        return $models;
    }


    #INSERT INTO table_name (column1, column2, column3, ...)
    #VALUES (value1, value2, value3, ...);
    public function insert()
    {
        if(empty($this->attributes)){
            return;
        }
        if ($this->isAutoInc) {
            $columlList = " (";
            $valuelList = " (";
            foreach ($this->attributes as $column => $value) {
                $columlList .= $column . ", ";
                $valuelList .= ":".$column . ", ";
            }
            $columlList = str_last_replace(", ", ")", $columlList);
            $valuelList = str_last_replace(", ", ")", $valuelList);
            $sqlQuery = "INSERT INTO " . $this->table . $columlList . " VALUES" . $valuelList;

            Db::instance()->execute($sqlQuery,$this->attributes);
            #println($sqlQuery, "blue");
        }
    }

//UPDATE table_name
//SET column1=value, column2=value2,...
//WHERE some_column=some_value
    public function update(){
        if(empty($this->attributes)){
            return;
        }
        if ($this->isAutoInc) {
            $fieldsList = " SET ";
            foreach ($this->attributes as $column => $value) {
                $fieldsList.=$column."=".'\''.$value.'\''.", ";
            }
            $fieldsList = str_last_replace(", ", "", $fieldsList);
            $sqlQuery = "UPDATE ".$this->table.$fieldsList." WHERE ".$this->idName."=".$this->attributes[$this->idName];

            Db::instance()->execute($sqlQuery,$this->attributes);
        }
    }


    public function delete(){
        if(empty($this->attributes)){
            return;
        }
        $sqlQuery = "DELETE FROM ".$this->table." WHERE ".$this->idName." = ".$this->attributes[$this->idName];
        Db::instance()->execute($sqlQuery,$this->attributes);
    }

    protected function setTable()
    {
        if (!isset($this->table)) {
            $className = get_class($this);
            $words = explode('\\',$className);
            $className = end($words);
            $this->table = strtolower($className) . "s";
        }
    }


}