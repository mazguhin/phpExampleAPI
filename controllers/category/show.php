<?php

$data = Request::dataFromGet();

$categories = $app['database']->show('shop_category', $data->id);

foreach ($categories as $key => $category)
{
    // получаем данные из доп. таблицы
    $products = $app['database']->where('shop_product_category', [
      'category_id' => $category->id
    ]);

    $category->products = [];
    $category->products_count = count($products);

    // перебираем полученные записи из доп. таблицы
    foreach ($products as $product)
    {
        // получаем запись из таблицы продуктов
        $result = $app['database']->where('shop_product', [
          'id' => $product->product_id
        ])[0];

        // закидываем найденную информацию в наш массив
        array_push($category->products, $result);
    };
}

header('Content-Type: application/json');
echo json_encode($categories[0]);
