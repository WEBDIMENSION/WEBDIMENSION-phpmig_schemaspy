<?php

use Phpmig\Migration\Migration;

class InsertUserRanks extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();
        $user_ranks_array = USERS_RANKS_ARRAY;

        for ($i = 0; $i < sizeof($user_ranks_array); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_USER_RANKS . "
               (
                   user_rank_name,
                   memo
               ) values (
                '" . $user_ranks_array[$i] . "',
                '" . $faker->realText(50) . "'
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
        TRUNCATE TABLE " . TABLE_USER_RANKS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
