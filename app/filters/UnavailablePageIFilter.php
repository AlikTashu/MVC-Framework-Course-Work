<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 29.05.2018
 * Time: 10:58
 */

namespace app\filters;

use vendor\core\base\IFilter;
use vendor\core\router\Route;


class UnavailablePageIFilter implements IFilter
{
    public function check(Route $route) : bool
    {
        return true;
    }

    public function callback()
    {
        throw new \Exception("Unavailable Page");
    }
}