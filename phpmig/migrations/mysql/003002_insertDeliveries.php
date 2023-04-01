<?php

use Phpmig\Migration\Migration;

class insertDeliveries extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);

        $container = $this->getContainer();


        for ($i = 0; $i < count(ORDERS_DELIVERIES); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_DELIVERIES . "
                        (
                            delivery_name,
                            delivery_cost,
                            memo
                        ) values (
                         '" . ORDERS_DELIVERIES[$i]['name'] . "',
                         " . ORDERS_DELIVERIES[$i]['cost'] . ",
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
        TRUNCATE TABLE " . TABLE_DELIVERIES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
