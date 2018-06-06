<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 11.04.2018
 * Time: 9:34
 */

namespace vendor\core\router;
use vendor\core\exception\BadUrlException;
use vendor\core\base\IFilter;
use vendor\core\utility\Logger;

class Router
{
    protected static $routes = [];
    protected static $currentRoute;
    protected static $defaultRoutePattern = "|^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?(/.+)?|";
    protected static $globalFilters =[];
    protected static $_MVCParams = [];



    public static function registerGlobalFilter(IFilter $filter){
        array_push(self::$globalFilters, $filter);
    }

    public static function addConcreteRoute(Route $route)
    {
        self::$routes[] = $route;
    }

    public static function add($uri,$controller,$action)
    {
        $newRoute = new Route($uri,$controller,$action);
        self::$routes[] = $newRoute;
        return $newRoute;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getCurrentRoute()
    {
        return self::$currentRoute;
    }

    public static function matchRoute(string $url) : bool
    {
        $url = self::removeQueryString($url);

        foreach (self::$routes as $route) {
            if ($route->matchRoute($url,self::$_MVCParams)) {
                self::$currentRoute = $route;
                $route->checkFilters();
                return true;
            }
        }

        if(preg_match(self::$defaultRoutePattern, $url, $matches)){

            if(array_key_exists('3',$matches)){
                self::$_MVCParams = explode('/',$matches[3]);
                array_shift(self::$_MVCParams);
            }
            foreach (self::$routes as $route){
                if($route->getAlternativeDefaultRoute() === $url) {
                    echo "ALTERNATIVE ROUTE MATCHED!" . "<br/>";
                    //todo: throw 404
                    return false;
                }
            }
            self::$currentRoute = new Route($url,$matches['controller'],$matches['action']);
            self::checkFilters();
            return true;
        }
        return false;
    }

    public static function checkFilters(){

        foreach(self::$globalFilters as $filter){
            if($filter->check(self::$currentRoute)){
                $filter->callback();
            }
        }
    }

    public static function dispatch(string $url) : void
    {
        #println($url,"blue");
        if(!self::matchRoute($url)){
            #println("DOESNT MATCH","red");
            #todo: throw 404
            return;
        }

        #println($url,"red");
        $controllerPath = "app\\controllers\\".self::upperCamelCase(self::$currentRoute->getController())."Controller";
        $action = self::lowerCamelCase(self::$currentRoute->getAction()."Action");


        if(!class_exists($controllerPath)){
            Logger::message("CONTROLLER: {$controllerPath}");
            throw new BadUrlException("Controller not found");
        }
        if(!method_exists($controllerPath, $action)){
            Logger::message("CONTROLLER: {$controllerPath} ACTION: {$action}");
            throw new BadUrlException("Action not found");
        }


        $controller = new $controllerPath(self::$currentRoute);
        $controller->_MVCParams = self::$_MVCParams;
        $controller->$action();

        $controller->getView();
    }



    protected static function upperCamelCase($name){
        return str_replace(' ','',ucwords(str_replace('-',' ',$name)));
    }

    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQueryString($url){
        if($url){
            $params = explode('&',$url,2);
            if(strpos($params[0],'=') === false){
                return trim($params[0],'/');
            }
            else
            {
                return '';
            }
        }
        return $url;
    }

}