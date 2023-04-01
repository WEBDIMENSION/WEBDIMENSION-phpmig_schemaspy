<?php

use Phpmig\Migration\Migration;

class CreateProducts extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_PRODUCTS . " (
            id SERIAL NOT NULL,
            product_code varchar(50) NOT NULL,
            shop_product_code varchar(50) NOT NULL,
            product_name varchar(50) NOT NULL,
            product_img varchar(255) NOT NULL,
            product_price numeric(10) NOT NULL,
            product_stock numeric(5) NOT NULL,
            product_maker varchar(50) NOT NULL,
            jan_code varchar(50) NOT NULL,
            catch_copy varchar(255) NOT NULL,
            description varchar(255) NOT NULL,
            category_id integer NOT NULL, 
            brand_id integer NOT NULL, 
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (category_id) REFERENCES " . TABLE_CATEGORIES . "(id) 
            ON DELETE CASCADE
            ON UPDATE CASCADE,
            FOREIGN KEY (brand_id) REFERENCES " . TABLE_BRANDS . "(id) 
            ON DELETE CASCADE
            ON UPDATE CASCADE
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
        DROP TABLE " . TABLE_PRODUCTS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
