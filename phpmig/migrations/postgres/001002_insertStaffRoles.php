<?php

use Phpmig\Migration\Migration;

class insertStaffRoles extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();
        $staff_roles_array = STAFF_ROLES_ARRAY;

        for ($i = 0; $i < sizeof($staff_roles_array); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_STAFF_ROLES . "
               (
                   name,
                   memo
               ) values (
                '" . $staff_roles_array[$i] . "',
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
        TRUNCATE TABLE " . TABLE_STAFF_ROLES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
