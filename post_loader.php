<?php

//bootstrap the app
include __DIR__.'/App/bootstrap.php';

//get pdo connection
$pdo = App\lib\Registry::getServiceOrParam('pdo');

//get path to articles
$path = App\lib\Registry::getServiceOrParam('path');

//get quantity of articles to load into db
$quantity = App\lib\Registry::getServiceOrParam('articles_count');

//create repository
$repository = new App\Model\PostRepository($pdo, $path);

//check the ratio of articles in the folder and the number in the config
$count = ($quantity > count(scandir($path)) - 2) ? count(scandir($path)) - 2 : $quantity;


for ($i = 0; $i < $count; $i++){
    $post = $repository->getRandomPostAndDelete();

    if (!$post)
        throw new \RuntimeException("Post is not defined");
    if (!$repository->insertIntoDataBase($post)){
        throw new \RuntimeException("Something wrong with inserting posts into DB");
    }
}