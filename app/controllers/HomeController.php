<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 03.06.2018
 * Time: 13:57
 */

namespace app\controllers;


class HomeController extends AppController
{
    public $layout = "default";

    public function mainAction(){
        $this->layout = "default";
    }

    public function catalogAction(){

    }

}