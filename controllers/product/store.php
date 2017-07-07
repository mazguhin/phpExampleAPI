<?php

$data = Request::dataFromPost();

$product = $app['database']->insert('shop_product', [
  'is_enabled' => $data->is_enabled,
  'name' => $data->name,
  'announce' => $data->announce,
  'description' => $data->description
]);

foreach($data->categories as $category) {
  $app['database']->insert('shop_product_category', [
    'category_id' => $category,
    'product_id' => $product,
  ]);
}

header('Content-Type: application/json');
echo json_encode(['result' => 'Продукт успешно добавлен']);
return;
