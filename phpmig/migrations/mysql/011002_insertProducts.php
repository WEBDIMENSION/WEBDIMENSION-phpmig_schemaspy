<?php

use Phpmig\Migration\Migration;

class insertProducts extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $product_ids = [];
        for ($i = 0; $i < PRODUCTS_DATA_ROWS_COUNT; $i++) {
            $product_ids[] = $i;
        }
        $deleted_ids = [];
        foreach (array_rand($product_ids, PRODUCTS_DELETED_ROWS_COUNT) as $key) {
            $deleted_ids[] = $product_ids[$key];
        }
        if (in_array($i, $deleted_ids)) {
            $delete_flg = 'true';
        } else {
            $delete_flg = 'false';
        }

        $stmt = $container['db']->query("SELECT id FROM " . TABLE_BRANDS);
        $brand_array = $stmt->fetchAll();

        $stmt = $container['db']->query("SELECT id FROM " . TABLE_CATEGORIES);
        $category_array = $stmt->fetchAll();

        for ($i = 0; $i < PRODUCTS_DATA_ROWS_COUNT; $i++) {
            $created_at = $faker->dateTimeBetween(USERS_CREATED_FROM, USERS_CREATED_TO)->format('Y-m-d H:i:s');
            if ($faker->numberBetween(1, 3) % 2 == 0) {
                $updated_at = date(
                    'Y-m-d H:i:s',
                    strtotime($created_at)
                    + ($faker->numberBetween(1, 12) * 30 * 24 * 60 * 60)
                    + ($faker->numberBetween(1, 30) * 24 * 60 * 60)
                    + ($faker->numberBetween(1, 12) * 60 * 60)
                    + ($faker->numberBetween(1, 60) * 60)
                    + $faker->numberBetween(1, 60)
                );
            } else {
                $updated_at = $created_at;
            }
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_PRODUCTS . "
               (
                   product_code,
                   shop_product_code,
                   product_name,
                   product_img,
                   product_price,
                   product_stock,
                   product_maker,
                   jan_code,
                   catch_copy,
                   description,
                   category_id,
                   brand_id,
                   delete_flg,
                   created_at,
                   updated_at
               ) values (
                '" . $faker->unique()->numerify('pid##########') . "',
                '" . $faker->unique()->numerify('shopPid##########') . "',
                '" . $faker->unique()->realText(20) . "',
                '" . $faker->imageUrl($width = '400', $height = '200', 'cats', true, 'Faker') . "',
                '" . $faker->numberBetween($min = PRODUCTS_PRICE_MIN, $max = PRODUCTS_PRICE_MAX) . "',
                '" . $faker->numberBetween($min = PRODUCTS_STOCK_MIN, $max = PRODUCTS_STOCK_MAX) . "',
                '" . $faker->word() . "',
                '" . $faker->unique()->ean13() . "',
                '" . $faker->realText(40) . "',
                '" . $faker->realText(200) . "',
                '" . $faker->randomElement($brand_array)['id'] . "',
                '" . $faker->randomElement($category_array)['id'] . "',
                " . $delete_flg . ",
                '" . $created_at . "',
                '" . $updated_at . "'
                
                );"
            );
            $stmt->execute([]);
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "
        TRUNCATE TABLE " . TABLE_PRODUCTS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
