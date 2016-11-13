<?php

class CatalogController
{
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProduct = array();
        $latestProduct = Product::getLatestProducts(12);

        require_once(ROOT.'/views/catalog/index.php');

        return true;
    }

    public function actionCategory($categoryId, $page = 1)
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);
        //echo 'все количество данных с базы в даной категории'; var_dump($total);
        //echo 'номер страницы'; var_dump($page);
        //echo 'количество данных на старницу'; var_dump(Product::SHOW_BY_DEFAULT);
        //echo 'page-';

        // Создан обьект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once(ROOT.'/views/catalog/category.php');

        return true;
    }
}