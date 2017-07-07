<?php

class Helper
{

  public static function getProducts($category, $app, &$products)
  {
      // получил продукты из доп таблицы
      $tmpProducts = $app['database']->where('shop_product_category', [
        'category_id' => $category->id
      ]);

      $products = array_merge($products, $tmpProducts);

      // находим подкатегории данной категории
      $subCategories = $app['database']->where('shop_category', [
        'parent' => $category->id
      ]);

      foreach ($subCategories as $cat) {
        self::getProducts($cat, $app, $products);
      }
  }

}
