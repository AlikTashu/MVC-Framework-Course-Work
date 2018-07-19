<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 06.06.2018
 * Time: 17:47
 */

namespace app\controllers;

use app\models\Brand;
use app\models\Category;
use app\models\Order;
use app\models\OrderItems;
use app\models\Product;
use vendor\core\Db;
use vendor\core\exception\BadUrlException;
use vendor\core\QueryBuilder;
use vendor\core\utility\Logger;

class ProductsController extends AppController
{
    public function catalogAction()
    {
        $productsOnPage = 9;
        $page = $this->getPage();
        $offset = ($page - 1) * $productsOnPage;
        $allCategories = Category::get();
        $allBrands = Brand::get();
        $data = $_GET;
        $arr = (explode('&', $_SERVER["QUERY_STRING"]));
        array_shift($arr);
        $queryParams = implode("&", $arr);
        $flg = false;

        $products = Product::join("models", "products.model_id", "models.id")->
        join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->limit($offset, $productsOnPage);

        if (isset($data["categories"][0])) {
            $categories = $data["categories"];
            $products = $products->whereBrace("(");
            foreach ($categories as $category) {
                $products = $products->where("categories.name", "=", $category, "OR");
            }
            $products = $products->whereBrace(")");
            $flg = true;
        }

        if (isset($data["brands"][0])) {
            $brands = $data["brands"];
            if ($flg) {
                $products = $products->whereBrace(" AND ");
            }
            $products = $products->whereBrace("(");
            foreach ($brands as $brands) {
                $products = $products->where("brands.name", "=", $brands, "OR");
            }
            $products = $products->whereBrace(")");
        }


        $products = $products->get();

        if (isset($data["sort_by"])) {
            usort($products, $this->getComparator($data["sort_by"]));
        }

        $productsCount = count($products);


        foreach ($products as $product) {
            $this->fillProductInfo($product);
        }


        $pages = $this->getPagesList($productsCount, $productsOnPage);
        $this->set(["products" => $products, "queryParams" => $queryParams, "categories" => $allCategories, "brands" => $allBrands, "pages" => $pages, "currentPage" => $page]);
    }

    public function checkoutAction(){
        Logger::message(var_export($_SESSION["user"],true));
        if(!isset($_SESSION["user"])){
            header("Location: /main");
        }
        if(!isset($_SESSION["products"])){
            header("Location: /main");
        }

        $user = $_SESSION["user"];

        $products = [];

        $productNumbers = $_SESSION["products"];
        foreach ($productNumbers as $number) {
            $product = Product::where("number", "=", $number)->join("models", "products.model_id", "models.id")->
            join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->first();
            $this->fillProductInfo($product);
            $products[] = $product;
        }


        $order = new Order([
            "user_id" => $user["id"],
            "order_date" => date( "Y-m-d H:i:s" ),
            "total_price"=> $_POST["total_price"]
        ]);
        $order->insert();

        $orderId = Db::instance()->getLastInsertId();

        Logger::message("NEW ORDER ID : {$orderId}");


        foreach ($products as $product)
        {
            $orderItem = new OrderItems([
                "order_id"=>$orderId,
                "product_id"=>$product->id
            ]);
            $orderItem->insert();
        }

        unset($_SESSION["products"]);


    }

    public function productAction()
    {
        if (!isset($this->_MVCParams[0])) {
            throw new BadUrlException("Product not defined");
        }
        $number = $this->_MVCParams[0];
        $product = Product::join("models", "products.model_id", "models.id")->
        join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->where("number", "=", $number)->first();
        $this->fillProductInfo($product);

        $this->set(["product" => $product]);

    }


    public function addAction()
    {
        if (!isset($this->_MVCParams[0])) {
            throw BadUrlException("Add to cart without number");
        }
        if (!isset($_SESSION["products"])) {
            $_SESSION["products"] = [];
        }
        $_SESSION["products"] [] = $this->_MVCParams[0];
        header("Location: /catalog");
    }

    public function deleteAction()
    {
        if (!isset($this->_MVCParams[0])) {
            throw BadUrlException("Delete from cart without number");
        }
        $id = 0;
        Logger::message(var_export($_SESSION["products"],true));
        foreach ($_SESSION["products"] as $key => $product) {
            Logger::message($key);
            if ($product == $this->_MVCParams[0]) {
                $id = $key;
                Logger::message("ID = {$id}");
            }
        }

        unset($_SESSION["products"][$id]);

        header("Location: /bag");
    }


    public function bagAction()
    {
        $productNumbers = $_SESSION["products"];
        if(!isset($productNumbers)){
            return;
        }
        $products = [];
        $totalPrice = 0;

        foreach ($productNumbers as $number) {
            $product = Product::where("number", "=", $number)->join("models", "products.model_id", "models.id")->
            join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->first();
            $this->fillProductInfo($product);
            $products[] = $product;
            $totalPrice += $product->totalDollars + $product->totalCents / 100;
        }


        $this->set(["products" => $products, "total_price" => $totalPrice]);
    }


    function getComparator($param)
    {
        if ($param == "price") {
            return array($this, "price_cmp");
        }
        if ($param == "name") {
            return array($this, "cmp");
        }
    }

    function cmp($a, $b)
    {
        return strcmp($a->title, $b->title);
    }

    function price_cmp($a, $b)
    {
        if ($a->price == $b->price) {
            return 0;
        }
        return ($a->price < $b->price) ? -1 : 1;
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

    /**
     * @param $productsCount
     * @param $productsOnPage
     * @param $pages
     * @return array
     */
    protected function getPagesList($productsCount, $productsOnPage): array
    {
        $pages = [];
        $pagesCount = round($productsCount / $productsOnPage, PHP_ROUND_HALF_DOWN) + 1;

        for ($i = 1; $i <= $pagesCount; $i++) {
            $pages[] = $i;
        }
        return $pages;
    }

    /**
     * @return int
     */
    protected function getPage(): int
    {
        $page = 1;
        if (isset($this->_MVCParams[0])) {
            $page = $this->_MVCParams[0];
        }
        return $page;
    }
}