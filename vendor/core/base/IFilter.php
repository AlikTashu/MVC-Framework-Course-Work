<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 29.05.2018
 * Time: 10:56
 */

namespace vendor\core\base;

use vendor\core\router\Route;

interface IFilter
{
   public function check(Route $route):bool;

   public function callback();

}