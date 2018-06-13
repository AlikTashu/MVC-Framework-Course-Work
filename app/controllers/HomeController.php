<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 03.06.2018
 * Time: 13:57
 */

namespace app\controllers;


use app\models\Product;

class HomeController extends AppController
{
    public $layout = "default";

    public function mainAction(){
        $products = Product::join("models", "products.model_id", "models.id")->
        join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->limit(0,6)->get();


        foreach ($products as $product)
        {
            $this->fillProductInfo($product);
        }

        $fearuredProducts=[];
        $fearuredProducts[] = $products[3];
        $fearuredProducts[] = $products[5];
        $fearuredProducts[] = $products[1];


        $this->set(["products" => $products,"featuredProducts" => $fearuredProducts]);
    }

    public function catalogAction(){

    }

    /**
     * @param $product
     */
    protected function fillProductInfo($product): void
    {
        $priceKoef = 1 -
            ($product->category_discount) / 100 -
            ($product->model_discount) / 100 -
            ($product->brand_discount) / 100;
        $totalCost = $product->price * $priceKoef;
        $product->totalDollars = round($totalCost / 100, 0, PHP_ROUND_HALF_DOWN);
        $product->totalCents = $totalCost % 100;
    }


}