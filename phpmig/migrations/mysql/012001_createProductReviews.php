<?php

use Phpmig\Migration\Migration;

class CreateProductReviews extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_PRODUCT_REVIEWS . " (
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `product_id` integer(11) NOT NULL,
            `user_id` integer(11) NOT NULL,
            `content` varchar(255) NOT NULL,
            `review_valuation` integer(1) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`),
            INDEX idx_pid(`product_id`), 
            INDEX idx_uid(`user_id`), 
            FOREIGN KEY (`product_id`) REFERENCES " . TABLE_PRODUCTS . "(`id`)
             ON DELETE CASCADE
             ON UPDATE CASCADE,
            FOREIGN KEY (`user_id`) REFERENCES " . TABLE_USERS . "(`id`)
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
        DROP TABLE " . TABLE_PRODUCT_REVIEWS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
