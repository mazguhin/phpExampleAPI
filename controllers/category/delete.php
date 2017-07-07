<?php

$data = Request::dataFromGet();

$countCategory = $app['database']->count('shop_category', [
  'id' => $data->id
]);

if ($countCategory==0) {
  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Категория не существует']);
  return;
}

// проверяем, является ли категория корневой
if ($data->id==1) {
  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Категория является корневой']);
  return;
}

// считаем кол-во подкатегорий
$subCategoryCount = count($app['database']->where('shop_category', [
  'parent' => "$data->id"
]));

if ($subCategoryCount>0) {
  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Категория содержит подкатегории']);
  return;
}

// считаем кол-во продуктов в категории
$productsCount = count($app['database']->where('shop_product_category', [
  'category_id' => "$data->id"
]));

if ($productsCount>0) {
  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Категория содержит продукты']);
  return;
}

$app['database']->delete('shop_category', [
  'id' => $data->id
]);

header('Content-Type: application/json');
echo json_encode(['result' => 'Категория успешно удалена']);
return;
