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
            id SERIAL NOT NULL,
            category_name varchar(50) NOT NULL,
            memo varchar(255) NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );
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
