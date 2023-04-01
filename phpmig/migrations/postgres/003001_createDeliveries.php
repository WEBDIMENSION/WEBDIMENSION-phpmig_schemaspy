<?php

use Phpmig\Migration\Migration;

class CreateDeliveries extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_DELIVERIES . " (
            id SERIAL NOT NULL,
            delivery_name varchar(50) NOT NULL,
            delivery_cost numeric(10) NOT NULL,
            memo varchar(255) NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            ) ;
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
        DROP TABLE " . TABLE_DELIVERIES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
