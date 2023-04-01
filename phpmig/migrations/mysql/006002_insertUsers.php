<?php

use Phpmig\Migration\Migration;

class InsertUsers extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $stmt = $container['db']->query("SELECT id FROM " . TABLE_USER_RANKS);
        $users_ranks_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user_ids = [];
        for ($i = 0; $i < USERS_DATA_ROWS_COUNT; $i++) {
            $user_ids[] = $i;
        }
        $deleted_ids = [];
        foreach (array_rand($user_ids, USERS_DELETED_ROWS_COUNT) as $key) {
            $deleted_ids[] = $user_ids[$key];
        }

        for ($i = 0; $i < USERS_DATA_ROWS_COUNT; $i++) {
            if (in_array($i, $deleted_ids)) {
                $deleted_flg = 'true';
            } else {
                $deleted_flg = 'false';
            }
            $birthday = $faker->dateTimeBetween(USERS_BIRTHDAY_FROM, USERS_BIRTHDAY_TO)->format('Y-m-d');
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

            $user_rank_number = mt_rand(0, count($users_ranks_array) - 1);
            $stmt = $container['db']->prepare(
                "
               insert into " . TABLE_USERS . " 
               (
                   firstname,
                   lastname,
                   firstname_kana,
                   lastname_kana,
                   birthday,
                   email,
                   phone_number,
                   password,
                   postcode,
                   prefecture,
                   address1,
                   address2,
                   user_rank_id,
                   memo,
                   delete_flg,
                   created_at,
                   updated_at
               ) values (
                '" . $faker->firstName . "',
                '" . $faker->lastName . "',
                '" . $faker->firstKanaName . "',
                '" . $faker->lastKanaName . "',
                '" . $birthday . "',
                '" . $faker->email . "',
                '" . $faker->phonenumber . "',
                '" . $faker->md5 . "',
                '" . $faker->postcode . "',
                '" . $faker->prefecture . "',
                '" . $faker->ward . $faker->city . "',
                '" . $faker->streetAddress . $faker->secondaryAddress . "',
                '" . $users_ranks_array[$user_rank_number]['id'] . "',
                '" . $faker->realText(30) . "',
                " . $deleted_flg . ",
                '" . $created_at . "',
                '" . $updated_at . "'
                )"
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
        TRUNCATE TABLE " . TABLE_USERS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
