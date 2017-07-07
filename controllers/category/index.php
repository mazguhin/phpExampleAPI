<?php

$categories = $app['database']->all('shop_category');

// перебираем все категории
foreach ($categories as $category)
{
  $category->products = [];

  Helper::getProducts($category, $app, $category->products);

  // оставляем от элементов только id продукта
  $category->products = array_map (function ($value) {
    return $value->product_id;
  }, $category->products);

  // убираем дубликаты
  $category->products = array_unique($category->products);

  // ну тут уже без php'шного count никак не обойтись :)
  $category->products_count = count($category->products);

}

header('Content-Type: application/json');
echo json_encode($categories);
