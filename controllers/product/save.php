<?php

$data = Request::dataFromPost();

$countProduct = $app['database']->count('shop_product', [
  'id' => $data->id
]);

if ($countProduct==0) {
//  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Продукт не существует']);
  return;
}

$products = $app['database']->update('shop_product', [
    'id' => $data->id,
    'is_enabled' => $data->is_enabled,
    'name' => $data->name,
    'announce' => $data->announce,
    'description' => $data->description
]);

header('Content-Type: application/json');
echo json_encode(['result' => 'Продукт успешно сохранен', 'status' => true]);
return;
