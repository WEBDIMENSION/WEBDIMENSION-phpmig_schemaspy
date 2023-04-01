<?php

use Phpmig\Migration\Migration;

class insertProductReviews extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $stmt = $container['db']->query("
            select * from " . TABLE_PRODUCTS);
        $products_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $container['db']->query("
            select * from " . TABLE_USERS);
        $users_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < PRODUCTS_REVIEW_ROWS_COUNT; $i++) {
            $reviews_product_id = $faker->randomElement($products_array)['id'];
            $reviews_users_id = $faker->randomElement($users_array)['id'];
            $created_at = $faker->dateTimeBetween(USERS_CREATED_FROM, USERS_CREATED_TO)->format('Y-m-d H:i:s');
            $updated_at = $created_at;
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_PRODUCT_REVIEWS . '
                        (
                            product_id,
                            user_id,
                            content,
                            review_valuation,
                            created_at,
                            updated_at
                        ) values (
                         \'' . $reviews_product_id . "',
                         '" . $reviews_users_id . "',
                         '" . $faker->realText(200) . "',
                         '" . $faker->numberBetween(1, 5) . "',
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
        TRUNCATE TABLE " . TABLE_PRODUCT_REVIEWS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
