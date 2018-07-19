<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 03.06.2018
 * Time: 21:02
 */

namespace app\models;


use vendor\core\base\Model;

class User extends Model
{
    protected $table = "users";


    public static function checkIfUserExistsByEmail($email) : bool{
        $users = User::where('email','=',"{$email}")->get();
        if(is_array($users)&&count($users)>0){
            return true;
        }
        return false;
    }

    public static function checkIfUserExistsByLogin($login) : bool{
        $users = User::where('login','=',"{$login}")->get();
        if(is_array($users)&&count($users)>0){
            return true;
        }
        return false;
    }

}

