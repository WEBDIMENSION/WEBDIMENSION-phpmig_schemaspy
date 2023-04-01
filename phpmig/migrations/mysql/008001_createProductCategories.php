<?php

use Phpmig\Migration\Migration;

class CreateProductCategories extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_CATEGORIES . " (
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `category_name` varchar(50) NOT NULL,
            `memo` varchar(255) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB;
            ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "
        DROP TABLE " . TABLE_CATEGORIES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
