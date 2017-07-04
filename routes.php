<?php

$router->get('', 'controllers/index.php');
$router->get('prod', 'controllers/prod.php');

$router->get('category', 'controllers/category/index.php');
$router->get('category/show', 'controllers/category/show.php');
$router->post('category', 'controllers/category/store.php');
$router->put('category', 'controllers/category/save.php');
$router->delete('category', 'controllers/category/delete.php');

$router->get('product', 'controllers/product/index.php');
$router->get('product/show', 'controllers/product/show.php');
$router->post('product', 'controllers/product/store.php');
$router->put('product', 'controllers/product/save.php');
$router->put('product/categories', 'controllers/product/categories.php');
$router->delete('product', 'controllers/product/delete.php');
