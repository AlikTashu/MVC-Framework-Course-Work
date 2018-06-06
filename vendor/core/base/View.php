<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 15.04.2018
 * Time: 21:34
 */

namespace vendor\core\base;


class View
{
    public $route;
    public $view;
    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        $this->view = $view;

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }

        #var_dump($this->layout);
        #var_dump($this->view);
    }

    public function render($vars)
    {
        #извлекаем значения из массива в таблицу символов (эквивалентно созданию переменных)
        if (is_array($vars)) {
            extract($vars);
        }

        $viewFilePath = APP . "/views/{$this->route->getController()}/{$this->view}.php";
        #открываем буфер
        ob_start();
        if (is_file($viewFilePath)) {
            require $viewFilePath;
        } else {
            echo "<p>View not found, <b>{$viewFilePath}</b><p>";
        }
        #скидываем содержимое файла в переменную content -> в лайауте можно вставить содержимое вью куда нужно
        $content = ob_get_clean();

        if ($this->layout !== false) {
            $layoutFilePath = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layoutFilePath)) {
                require $layoutFilePath;
            } else {
                echo "<p style='color:red;'>Layout not found <b>$layoutFilePath</b></p>";
            }
        }

    }
}
