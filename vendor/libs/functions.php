<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 11.04.2018
 * Time: 9:45
 */

function debug($arr){
    echo "<pre>" .print_r($arr,true)."</pre>";
}

function SQL($query,$params = []){
    return \vendor\core\Db::instance()->query($query,$params);
}

function is_assoc_array(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function str_last_replace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

function println($msg, $color = "black")
{
    echo "<span style = \"color:" . $color . "\">" . $msg . "</span><br/>";
}

function encryptStr( $q ) {

    $stringLength = strlen($q);
    for ($i = 0; $i < $stringLength; $i++)
        $q[$i] = $q[$i]^5;
    return( $q );
}

function decryptStr( $q ) {
    $stringLength = strlen($q);
    for ($i = 0; $i < $stringLength; $i++)
        $q[$i] = $q[$i]|5;
    return( $q );
}


