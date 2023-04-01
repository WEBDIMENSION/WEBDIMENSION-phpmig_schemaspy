<?php

use Phpmig\Migration\Migration;

class insertOrders extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $stmt = $container['db']->query("SELECT * FROM " . TABLE_USERS);
        $users_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $container['db']->query("SELECT * FROM " . TABLE_STAFFS);
        $staffs_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < ORDERS_DATA_ROWS_COUNT; $i++) {
            $created_at = $faker->dateTimeBetween(USERS_CREATED_FROM, USERS_CREATED_TO)->format('Y-m-d H:i:s');
            $updated_at = $created_at;
            $user_id_number = mt_rand(0, count($users_array) - 1);
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_ORDERS . "
               (
                   order_id,
                   user_id,
                   firstname,
                   lastname,
                   firstname_kana,
                   lastname_kana,
                   email,
                   phone_number,
                   postcode,
                   prefecture,
                   address1,
                   address2,
                   user_rank_id,
                   staff_id,
                   created_at,
                   updated_at
               ) values (
                '" . $faker->dateTimeBetween(USERS_CREATED_FROM, USERS_CREATED_TO)->format('Y-m-d')
                . $faker->unique->randomNumber(9) . "',
                " . $users_array[$user_id_number]['id'] . ",
                '" . $users_array[$user_id_number]['firstname'] . "',
                '" . $users_array[$user_id_number]['lastname'] . "',
                '" . $users_array[$user_id_number]['firstname_kana'] . "',
                '" . $users_array[$user_id_number]['lastname_kana'] . "',
                '" . $users_array[$user_id_number]['email'] . "',
                '" . $users_array[$user_id_number]['phone_number'] . "',
                " . $users_array[$user_id_number]['postcode'] . ",
                '" . $users_array[$user_id_number]['prefecture'] . "',
                '" . $users_array[$user_id_number]['address1'] . "',
                '" . $users_array[$user_id_number]['address2'] . "',
                " . $users_array[$user_id_number]['user_rank_id'] . ",
                " . $faker->randomElement($staffs_array)['id'] . ",
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
        TRUNCATE TABLE " . TABLE_ORDERS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
