<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 04.06.2018
 * Time: 1:42
 */

namespace vendor\core\utility;

class Mail
{
    public $reciever;
    public $subject;
    public $message;


    public function __construct($reciever, $subject,$message)
    {
        $this->reciever= $reciever;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function send(){
        return mail($this->reciever,$this->subject,$this->message);
    }

    public static function rememberPassword($email,$hash){
        $subject = "Restoring password";
        $link = "http://shoes.loc/password/".$hash;
        $message = "To restore your password on ShoeShop follow the link: ".$link;

        mail($email,$subject,$message);
    }

    public static function verifyEmail($user){
        $to = $user->email;
        $subject = "Confirm";
        $link = "http://shoes.loc/verify/".$user->hashcode;
        $txt = "Hi, {$user->login}! Verify your e-mail to finish signing up for ShoeShop. \r\nThank you for choosing ShoeShop. Please confirm that ".$user->email." is your e-mail address by clicking this link \r\n"."{$link} .";
        mail($to,$subject,$txt);
    }

}