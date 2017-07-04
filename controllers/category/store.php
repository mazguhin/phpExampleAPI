<?php

$data = Request::dataFromPost();

$categories = $app['database']->insert('shop_category', [
    'parent' => $data->parent,
    'is_enabled' => $data->is_enabled,
    'name' => $data->name
]);

echo 'Категория успешно добавлена';
return;
