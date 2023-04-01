<?php

use Phpmig\Migration\Migration;

class CreateOrderDetails extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_ORDER_DETAILS . " (
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `order_id` varchar(50) NOT NULL,
            `product_id` integer(11) NOT NULL,
            `product_code` varchar(50) NOT NULL,
            `shop_product_code` varchar(50) NOT NULL,
            `product_name` varchar(50) NOT NULL,
            `product_price` integer NOT NULL,
            `product_quantity` integer NOT NULL,
            `jan_code` varchar(50) NOT NULL,
            `category_id` integer(11) NOT NULL,
            `brand_id` integer(11) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`),
            INDEX idx(`order_id`), 
            FOREIGN KEY (`order_id`) REFERENCES " . TABLE_ORDERS . "(`order_id`)
             ON DELETE CASCADE
             ON UPDATE CASCADE,
            FOREIGN KEY (`product_id`) REFERENCES " . TABLE_PRODUCTS . "(`id`)
             ON DELETE CASCADE
             ON UPDATE CASCADE
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
        DROP TABLE " . TABLE_ORDER_DETAILS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
