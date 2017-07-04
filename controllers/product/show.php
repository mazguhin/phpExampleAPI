<?php

$data = Request::dataFromGet();

$product = $app['database']->show('shop_product', $data->id);

header('Content-Type: application/json');
echo json_encode($product);
