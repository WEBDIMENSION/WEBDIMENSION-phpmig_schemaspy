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
            id SERIAL NOT NULL,
            order_id varchar(50) NOT NULL,
            product_id integer NOT NULL,
            product_code varchar(50) NOT NULL,
            shop_product_code varchar(50) NOT NULL,
            product_name varchar(50) NOT NULL,
            product_price numeric(10) NOT NULL,
            product_quantity numeric(5) NOT NULL,
            jan_code varchar(50) NOT NULL,
            category_id integer NOT NULL,
            brand_id integer NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (order_id) REFERENCES " . TABLE_ORDERS . "(order_id)
             ON DELETE CASCADE
             ON UPDATE CASCADE,
            FOREIGN KEY (product_id) REFERENCES " . TABLE_PRODUCTS . "(id)
             ON DELETE CASCADE
             ON UPDATE CASCADE
            );
            
            ";
        $container = $this->getContainer();
        $container['db']->query($sql);

        $sql = "CREATE INDEX idx_orders_id_orders_detail ON " . TABLE_ORDER_DETAILS . "  (order_id);";
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
