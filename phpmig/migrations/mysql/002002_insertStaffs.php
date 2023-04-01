<?php

use Phpmig\Migration\Migration;

class insertStaffs extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();
        $stmt = $container['db']->query("SELECT id FROM " . TABLE_STAFF_ROLES);
        $staff_rolles_array = $stmt->fetchAll();

        for ($i = 0; $i < STAFFS_ROWS_COUNT; $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_STAFFS . "
               (
                   name,
                   staff_role_id,
                   memo
               ) values (
                '" . $faker->name . "',
                '" . $faker->randomElement($staff_rolles_array)['id'] . "',
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
        TRUNCATE TABLE " . TABLE_STAFFS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
