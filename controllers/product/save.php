<?php

$data = Request::dataFromPost();

$products = $app['database']->update('shop_product', [
    'id' => $data->id,
    'is_enabled' => $data->is_enabled,
    'name' => $data->name,
    'announce' => $data->announce,
    'description' => $data->description
]);

echo 'Продукт успешно сохранен';
return;
