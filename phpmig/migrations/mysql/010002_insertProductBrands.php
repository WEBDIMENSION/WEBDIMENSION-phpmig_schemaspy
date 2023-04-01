<?php

use Phpmig\Migration\Migration;

class insertProductBrands extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);

        $container = $this->getContainer();


        for ($i = 0; $i < count(ORDERS_BRANDS); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_BRANDS . "
                        (
                            brand_name,
                            memo
                        ) values (
                         '" . ORDERS_BRANDS[$i]['name'] . "',
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
        TRUNCATE TABLE " . TABLE_BRANDS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
