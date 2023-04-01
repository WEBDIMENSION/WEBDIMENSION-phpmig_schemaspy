<?php

use Phpmig\Migration\Migration;

class CreateOrderTotals extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_ORDER_TOTALS . " (
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `order_id` varchar(50) NOT NULL,
            `sub_total` integer(10) NOT NULL,
            `delivery_id` integer(11) NOT NULL,
            `delivery_name` varchar(50) NOT NULL,
            `delivery_cost` integer(11) NOT NULL,
            `payment_id` integer(11) NOT NULL,
            `payment_name` varchar(50) NOT NULL,
            `payment_cost` integer(11) NOT NULL,
            `order_total` integer(10) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`),
            FOREIGN KEY (`order_id`) REFERENCES " . TABLE_ORDER_DETAILS . "(`order_id`)
             ON DELETE CASCADE
             ON UPDATE CASCADE,
            FOREIGN KEY (`delivery_id`) REFERENCES " . TABLE_DELIVERIES . "(`id`),
            FOREIGN KEY (`payment_id`) REFERENCES " . TABLE_PAYMENTS . "(`id`)
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
        DROP TABLE " . TABLE_ORDER_TOTALS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
