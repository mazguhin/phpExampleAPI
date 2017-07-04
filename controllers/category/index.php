<?php

$categories = $app['database']->all('shop_category');

// перебираем все категории
foreach ($categories as $category)
{
    // считаем кол-во продуктов в каждой категории
    $category->products_count = count($app['database']->where('shop_product_category', [
      'category_id' => "$category->id"
    ]));
}

header('Content-Type: application/json');
echo json_encode($categories);
