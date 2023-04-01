<?php

use Phpmig\Migration\Migration;

class insertProductCategories extends Migration
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
                "insert into " . TABLE_CATEGORIES . "
                        (
                            category_name,
                            memo
                        ) values (
                         '" . ORDERS_CATEGORIES[$i]['name'] . "',
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
        TRUNCATE TABLE " . TABLE_CATEGORIES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
