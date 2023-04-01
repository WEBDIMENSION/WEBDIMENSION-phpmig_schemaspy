<?php

use Phpmig\Migration\Migration;

class insertPayments extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        for ($i = 0; $i < count(ORDERS_PAYMENTS); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_PAYMENTS . "
                        (
                            payment_name,
                            payment_cost,
                            memo
                        ) values (
                         '" . ORDERS_PAYMENTS[$i]['name'] . "',
                         " . ORDERS_PAYMENTS[$i]['cost'] . ",
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
        TRUNCATE TABLE " . TABLE_PAYMENTS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
