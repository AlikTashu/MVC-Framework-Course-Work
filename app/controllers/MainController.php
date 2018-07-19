<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 12.04.2018
 * Time: 0:46
 */

namespace app\controllers;


use app\models\Article;
use app\models\Main;
use vendor\core\Db;
use vendor\core\QueryBuilder;

class MainController extends AppController
{

    public $layout = "default";

    public function indexAction()
    {
        echo '<p style = "color:blue">' . __METHOD__ . '</p>';

        $article = Article::first();
        $article->title = "test update";
        $article->save();

        $articles = QueryBuilder::table('articles')->join('authors', 'authors.id', 'articles.authorId')->get();

        $this->set(compact('articles', 'article', 'test'));
    }

    public function noLayoutAction()
    {

        $data = $_POST;

        if(isset($data["test_btn"])){
            println("DATA RECIEVED: ".$data["test_var"]."!!!!","red");
        }
        var_dump($this->_MVCParams);
        $this->layout = false;
        echo '<p style = "color:blue">' . __METHOD__ . '</p>';
    }

    public function kekAction()
    {
        $this->layout = "kek";
        $this->view = "index";


    }
}