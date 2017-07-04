<?php

$products = $app['database']->all('shop_product');

// перебираем все продукты
foreach ($products as $product)
{
    // для каждого продукта записываем список категорий
    $categories = $app['database']->where('shop_product_category', [
      'product_id' => "$product->id"
    ]);

    $product->categories = [];

    foreach ($categories as $category) {
      array_push($product->categories, $category->category_id);
    }
}

header('Content-Type: application/json');
echo json_encode($products);
