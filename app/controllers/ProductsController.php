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
use app\models\Product;
use vendor\core\QueryBuilder;

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
        $flg=false;

        $products = Product::join("models", "products.model_id", "models.id")->
        join("categories", "models.category_id", "categories.id")->join("brands", "models.brand_id", "brands.id")->limit($offset, $productsOnPage);

        if (isset($data["categories"][0])) {
            $categories = $data["categories"];
            $products = $products->whereBrace("(");
            foreach ($categories as $category) {
                $products = $products->where("categories.name", "=", $category, "OR");
            }
            $products = $products->whereBrace(")");
            $flg=true;
        }

        if (isset($data["brands"][0])) {
            $brands = $data["brands"];
            if($flg){
                $products = $products->whereBrace(" AND ");
            }
            $products = $products->whereBrace("(");
            foreach ($brands as $brands) {
                $products = $products->where("brands.name", "=", $brands, "OR");
            }
            $products = $products->whereBrace(")");
        }


        $products = $products->get();

        if(isset($data["sort_by"])){
            usort($products, $this->getComparator($data["sort_by"]));
        }

        $productsCount = count($products);


        foreach ($products as $product) {
            $this->fillProductInfo($product);
        }


        $pages = $this->getPagesList($productsCount, $productsOnPage);
        $this->set(["products" => $products, "queryParams" => $queryParams, "categories" => $allCategories, "brands" => $allBrands, "pages" => $pages, "currentPage" => $page]);
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