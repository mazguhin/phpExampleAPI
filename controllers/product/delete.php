<?php

$data = Request::dataFromGet();

$countProduct = $app['database']->count('shop_product', [
  'id' => $data->id
]);

if ($countProduct==0) {
  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Продукт не существует']);
  return;
}

// получаем категории продукта
$categories = $app['database']->where('shop_product_category', [
  'product_id' => "$data->id"
]);

// удаляем все связи с категориями данного продукта
foreach ($categories as $category) {
  $app['database']->delete('shop_product_category', [
    'id' => $category->id,
  ]);
}

$app['database']->delete('shop_product', [
  'id' => $data->id,
]);

header('Content-Type: application/json');
echo json_encode(['result' => 'Продукт успешно удален']);
return;
