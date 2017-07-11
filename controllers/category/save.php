<?php

$data = Request::dataFromPost();

$countCategory = $app['database']->count('shop_category', [
  'id' => $data->id
]);

if ($countCategory==0) {
//  header("HTTP/1.1 404 Error");
  header('Content-Type: application/json');
  echo json_encode(['result' => 'Категория не существует', 'status' => '0']);
  return;
}

$categories = $app['database']->update('shop_category', [
  'id' => $data->id,
  'parent' => $data->parent,
  'is_enabled' => $data->is_enabled,
  'name' => $data->name
]);

header('Content-Type: application/json');
echo json_encode(['result' => 'Категория успешно сохранена', 'status' => '1']);
