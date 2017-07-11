<?php

$data = Request::dataFromPost();

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

foreach($data->categories as $category) {
  $app['database']->insert('shop_product_category', [
    'category_id' => $category,
    'product_id' => $data->id,
  ]);
}

header('Content-Type: application/json');
echo json_encode(['result' => 'Продукт успешно сохранен', 'status' => '1']);
return;
