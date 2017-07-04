<?php

$data = Request::dataFromGet();

// проверяем, является ли категория корневой
if ($data->id==1) {
  header("HTTP/1.1 404 Error");
  echo 'Категория является корневой';
  return;
}

// считаем кол-во подкатегорий
$subCategoryCount = count($app['database']->where('shop_category', [
  'parent' => "$data->id"
]));

if ($subCategoryCount>0) {
  header("HTTP/1.1 404 Error");
  echo 'Категория содержит подкатегории';
  return;
}

// считаем кол-во продуктов в категории
$productsCount = count($app['database']->where('shop_product_category', [
  'category_id' => "$data->id"
]));

if ($productsCount>0) {
  header("HTTP/1.1 404 Error");
  echo 'Категория содержит продукты';
  return;
}

$app['database']->delete('shop_category', [
  'id' => $data->id
]);

echo 'Категория успешно удалена';
return;
