<?php

use Phpmig\Migration\Migration;

class InsertLoginHistories extends Migration
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

        for ($i = 0; $i < LOGIN_HISTORY_DATA_ROWS_COUNT; $i++) {
            $user_id_number = mt_rand(0, count($users_array) - 1);

            $stmt = $container['db']->query(
                "SELECT * FROM " . TABLE_LOGIN_HISTORIES . "
                    WHERE user_id = " . $users_array[$user_id_number]['id'] . "
                    ORDER  BY created_at
                    LIMIT 1 "
            );
            $lastLoginRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($lastLoginRow) {
                $created_at = date(
                    'Y-m-d H:i:s',
                    strtotime($lastLoginRow['created_at'])
                    + ($faker->numberBetween(1, 3) * 30 * 24 * 60 * 60)
                    + ($faker->numberBetween(1, 30) * 24 * 60 * 60)
                    + ($faker->numberBetween(1, 12) * 60 * 60)
                    + ($faker->numberBetween(1, 60) * 60)
                    + $faker->numberBetween(1, 60)
                );
            } else {
                $created_at = $users_array[$user_id_number]['created_at'];
            }

            $stmt = $container['db']->prepare(
                "insert into " . TABLE_LOGIN_HISTORIES . "
               (
                   user_id,
                   date,
                   ua,
                   ipv4,
                   delete_flg,
                   created_at,
                   updated_at
               ) values (
                '" . $users_array[$user_id_number]['id'] . "',
                '" . $created_at . "',
                '" . $faker->userAgent . "',
                '" . $faker->ipv4 . "',
                '" . $users_array[$user_id_number]['delete_flg'] . "',
                '" . $created_at . "',
                '" . $created_at . "'
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
        TRUNCATE TABLE " . TABLE_LOGIN_HISTORIES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
