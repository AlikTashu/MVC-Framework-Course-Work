<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 24.04.2018
 * Time: 0:32
 */

namespace vendor\core;


use vendor\core\utility\Logger;

class QueryBuilder
{

    protected $table;
    protected $select = [];
    protected $join = [];
    protected $where = [];
    protected $orderby = [];
    protected $limit = [];
    protected $parameters = [];
    public $query;

    protected function __construct($tableName)
    {
        $this->table = $tableName;
    }

    public static function table($tableName)
    {
        return new self($tableName);
    }

    public function where($field1, $relation, $field2, $logicalOp = 'AND')
    {
        array_push($this->where, ['field1' => $field1, 'relation' => $relation, 'field2' => $field2, 'logicalOp' => $logicalOp,]);
        return $this;
    }

    public function select(... $selectedFields)
    {
        $this->select = $selectedFields;
        return $this;
    }

    public function orderBy(... $orderFields)
    {
        $this->orderby = $orderFields;
        return $this;
    }

    public function limit($limitFrom, $limitTo = '')
    {
        $this->limit['from'] = $limitFrom;
        $this->limit['to'] = $limitTo;
        return $this;
    }

    public function join($table, $field1, $field2)
    {
        array_push($this->join, ['table' => $table, 'field1' => $field1, 'field2' => $field2]);
        return $this;
    }

    public function get()
    {
        $this->compile();
        Logger::message($this->query);
        return Db::instance()->query($this->query, $this->parameters);
    }

    public function first()
    {
        $this->compile();

        $resultSet = Db::instance()->query($this->query, $this->parameters);
        if (!empty($resultSet)) {
            return $resultSet[0];
        }
    }

    //todo: use prepare statement;

    private function compile()
    {
//        $selectString = 'SELECT ';
//        if (count($this->select) === 0) {
//            $selectString .= '*,';
//        } else {
//
//            foreach ($this->select as $item) {
//                $selectString .=$item . ',';
//            }
//        }
//        $selectString = rtrim($selectString, ', ');
//        $selectString .= ' FROM ' . $this->table . ' ';
//
//
//        $joinString = '';
//        foreach ($this->join as $item) {
//            $joinString .= "JOIN {$item['table']} ON {$item['field1']} = {$item['field2']} ";
//        }
//
//        $whereString = '';
//        if (count($this->where) !== 0) {
//            $whereString = 'WHERE ';
//
//            for ($i = 0; $i < count($this->where); $i++) {
//                $whereString .= $this->where[$i]['field1'] . ' ' . $this->where[$i]['relation'] . ' ' . $this->where[$i]['field2'] . ' ';
//                if ($i !== count($this->where) - 1) {
//                    $whereString .= $this->where[$i]['logicalOp'] . ' ';
//                }
//            }
//        }
//
//        $orderByString = '';
//        if (count($this->orderby) !== 0) {
//            $orderByString = 'ORDER BY ';
//            foreach ($this->orderby as $item) {
//                $orderByString .= $item . ', ';
//            }
//            $orderByString = rtrim($orderByString, ', ');
//        }
//
//
//        $limitString = '';
//        if (count($this->limit) !== 0) {
//            $limitString = " LIMIT {$this->limit['from']}, {$this->limit['to']} ";
//            $limitString = rtrim($limitString, ', ');
//        }
//        $this->query =
//             $selectString
//            .$joinString
//            .$whereString
//            .$orderByString
//            .$limitString;
        $selectString = 'SELECT ';
        if (count($this->select) === 0) {
            $selectString .= '*,';
        } else {

            foreach ($this->select as $item) {
                $selectString .= $item . ',';
            }
        }
        $selectString = rtrim($selectString, ', ');
        $selectString .= ' FROM ' . $this->table . ' ';


        $joinString = '';
        foreach ($this->join as $item) {
            $joinString .= "JOIN {$item['table']} ON {$item['field1']} = {$item['field2']} ";
        }

        $whereString = '';
        if (count($this->where) !== 0) {
            $whereString = 'WHERE ';

            for ($i = 0; $i < count($this->where); $i++) {
                $whereString .= $this->where[$i]['field1']." ". $this->where[$i]['relation'] . ' ?' . ' ';
                array_push($this->parameters, $this->where[$i]['field2']);
                if ($i !== count($this->where) - 1) {
                    $whereString .= '?' . ' ';
                    array_push($this->parameters, $this->where[$i]['logicalOp']);
                }
            }
        }

        $orderByString = '';
        if (count($this->orderby) !== 0) {
            $orderByString = 'ORDER BY ';
            foreach ($this->orderby as $item) {
                $orderByString .= $item . ', ';
            }
            $orderByString = rtrim($orderByString, ', ');
        }


        $limitString = '';
        if (count($this->limit) !== 0) {
            $limitString = " LIMIT '?', '?' ";
            array_push($this->parameters, $this->limit['from']);
            array_push($this->parameters, $this->limit['to']);
            $limitString = rtrim($limitString, ', ');
        }
        $this->query =
            $selectString
            . $joinString
            . $whereString
            . $orderByString
            . $limitString;

    }


}