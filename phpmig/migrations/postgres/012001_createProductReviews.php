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
            id SERIAL NOT NULL,
            product_id integer NOT NULL,
            user_id integer NOT NULL,
            content varchar(255) NOT NULL,
            review_valuation numeric(1) NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (product_id) REFERENCES " . TABLE_PRODUCTS . "(id)
             ON DELETE CASCADE
             ON UPDATE CASCADE,
            FOREIGN KEY (user_id) REFERENCES " . TABLE_USERS . "(id)
             ON DELETE CASCADE
             ON UPDATE CASCADE
            ) ;
            ";
        $container = $this->getContainer();
        $container['db']->query($sql);

        $sql = "
        create index idx_product_id on " . TABLE_PRODUCT_REVIEWS . "(product_id);
        ";
        $container['db']->query($sql);

        $sql = "
        create index idx_users_id on " . TABLE_PRODUCT_REVIEWS . "(user_id);
        ";
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
