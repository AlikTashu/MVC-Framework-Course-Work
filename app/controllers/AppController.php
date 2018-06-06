<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 15.04.2018
 * Time: 23:15
 */

namespace app\controllers;


use vendor\core\base\Controller;


//для добавления функциональности всем контроллерам,
// не залазя в core
class AppController extends Controller
{
    public $layout = "default";
}