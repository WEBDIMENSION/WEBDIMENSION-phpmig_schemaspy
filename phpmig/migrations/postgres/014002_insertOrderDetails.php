<?php

use Phpmig\Migration\Migration;

class insertOrderDetails extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $stmt = $container['db']->query("SELECT * FROM " . TABLE_ORDERS);
        $orders_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = $container['db']->query("SELECT * FROM " . TABLE_PRODUCTS);
        $products_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products_count = count($products_array);

        for ($i = 0; $i < count($orders_array); $i++) {
            $tmp_product_rows_cnt = mt_rand(ORDER_DETAILS_PRODUCT_ROWS_MIN_COUNT, ORDER_DETAILS_PRODUCT_ROWS_MAX_COUNT);
            for ($j = 0; $j < $tmp_product_rows_cnt; $j++) {
                $tmp_product_id = mt_rand(0, $products_count - 1);
                $stmt = $container['db']->prepare(
                    "insert into " . TABLE_ORDER_DETAILS . "
                        (
                            order_id,
                            product_id,
                            product_code,
                            shop_product_code,
                            product_name,
                            product_price,
                            product_quantity,
                            jan_code,
                            category_id,
                            brand_id,
                            created_at,
                            updated_at
                        ) values (
                         '" . $orders_array[$i]['order_id'] . "',
                         '" . $products_array[$tmp_product_id]['id'] . "',
                         '" . $products_array[$tmp_product_id]['product_code'] . "',
                         '" . $products_array[$tmp_product_id]['shop_product_code'] . "',
                         '" . $products_array[$tmp_product_id]['product_name'] . "',
                         '" . $products_array[$tmp_product_id]['product_price'] . "',
                         '" . $faker->numberBetween(
                        $min = ORDER_DETAILS_QUANTITY_MIN_COUNT,
                        $max = ORDER_DETAILS_QUANTITY_MAX_COUNT
                    ) . "',
                         '" . $products_array[$tmp_product_id]['jan_code'] . "',
                         '" . $products_array[$tmp_product_id]['category_id'] . "',
                         '" . $products_array[$tmp_product_id]['brand_id'] . "',
                         '" . $orders_array[$i]['created_at'] . "',
                         '" . $orders_array[$i]['updated_at'] . "'
                         );"
                );
                $stmt->execute([]);
            }
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "
        TRUNCATE TABLE " . TABLE_ORDER_DETAILS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
