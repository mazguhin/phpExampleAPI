<?php

$data = Request::dataFromPost();

$categories = $app['database']->insert('shop_category', [
    'parent' => $data->parent,
    'is_enabled' => $data->is_enabled,
    'name' => $data->name
]);

header('Content-Type: application/json');
echo json_encode(['result' => 'Категория успешно добавлена', 'status' => '1']);
