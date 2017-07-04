<?php

$data = Request::dataFromGet();

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

echo 'Продукт успешно удален';
return;
