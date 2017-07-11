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

  // удаляет категории и все ее дочерние
  public static function deleteCategory($category, $app) {

      // получаем продукты категории
      $products = $app['database']->where('shop_product_category', [
          'category_id' => $category->id
      ]);

      foreach ($products as $product) {

          // смотрим принадлежит ли продукт какой-либо еще категории
          $countPivot = $app['database']->count('shop_product_category', [
              'product_id' => $product->product_id
          ]);

          // удаляем связь категории с продуктом
          $app['database']->deleteWhere('shop_product_category', [
              'product_id' => $product->product_id,
              'category_id' => $category->id
          ]);

          // смотрим принадлежит ли продукт какой-либо еще категории
          $countPivot = $app['database']->count('shop_product_category', [
              'product_id' => $product->product_id
          ]);

          if ($countPivot==0) {
              $app['database']->delete('shop_product', [
                  'id' => $product->product_id
              ]);
          }
      }

      // находим подкатегории данной категории
      $subCategories = $app['database']->where('shop_category', [
          'parent' => $category->id
      ]);

      foreach ($subCategories as $cat) {
          self::deleteCategory($cat, $app);
      }

      // удалить пустую категорию
      $app['database']->delete('shop_category', [
          'id' => $category->id
      ]);

  }

}
