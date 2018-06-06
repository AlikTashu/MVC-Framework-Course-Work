<?php
$options = [
    \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC
];
return[
    'dsn' => 'mysql:host=192.168.1.181;dbname=shoeshop;charset=utf8',
    'user'=>'root',
    'pass'=>'',
    'options'=>$options
];