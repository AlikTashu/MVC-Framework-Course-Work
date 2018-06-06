<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 24.04.2018
 * Time: 1:52
 */

class Stack
{
    protected $stack;

    public function __construct()
    {
        $this->stack = array();
    }

    public function push($item)
    {
        array_unshift($this->stack, $item);
    }

    public function pop()
    {
        if ($this->isEmpty()) {
            throw new RunTimeException('Stack is empty!');
        } else {
            return array_shift($this->stack);
        }
    }

    public function top()
    {
        return current($this->stack);
    }

    public function isEmpty()
    {
        return empty($this->stack);
    }
}