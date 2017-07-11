<?php

$data = Request::dataFromGet();

$category = $app['database']->show('shop_category', $data->id);

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

// заменяем id продукта на полную информацию
$category->products = array_map (function ($value) use ($app) {
  // достаем продукт по его id
  $result = $app['database']->show('shop_product', $value);
  //подменяем значение в массиве на объект с данными о продукте
  return $result;
}, $category->products);

$category->status = 1;

header('Content-Type: application/json');
echo json_encode($category);
