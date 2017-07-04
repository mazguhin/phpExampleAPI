<?php

$data = Request::dataFromPost();

$categories = $app['database']->update('shop_category', [
  'id' => $data->id,
  'parent' => $data->parent,
  'is_enabled' => $data->is_enabled,
  'name' => $data->name
]);

echo 'Категория успешно сохранена';
return;
