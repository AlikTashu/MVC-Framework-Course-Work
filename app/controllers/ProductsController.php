<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 06.06.2018
 * Time: 17:47
 */

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use vendor\core\QueryBuilder;

class ProductsController extends AppController
{
    public function catalogAction()
    {
        $page =1;
        if (isset($this->_MVCParams[0])) {
            $page=$this->_MVCParams[0];
        }


        $lowerProduct=($page-1)*9;
        $higherProduct=$page*9;


        $products = Product::join("models", "products.model_id", "models.id")->
        join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->limit($lowerProduct,$higherProduct)->get();

        $categories = Category::get();

        $pages = [];
        $pagesCount = round(count($products) / 9, PHP_ROUND_HALF_DOWN) + 1;

        for ($i = 1; $i <= $pagesCount; $i++) {
            $pages[] = $i;
        }
        foreach ($products as $product) {
            $priceKoef = 1 -
                ($product->category_discount) / 100 -
                ($product->model_discount) / 100 -
                ($product->brand_discount) / 100;
            $totalCost = $product->price * $priceKoef;
            $product->totalDollars = round($totalCost / 100, 0, PHP_ROUND_HALF_DOWN);
            $product->totalCents = $totalCost % 100;
        }
        $this->set(["products" => $products, "categories" => $categories, "pages" => $pages]);
    }
}