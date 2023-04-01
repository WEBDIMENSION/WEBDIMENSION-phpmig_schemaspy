<?php

use Phpmig\Migration\Migration;

class createUsers extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
       CREATE TABLE " . TABLE_USERS . " (
            id SERIAL NOT NULL,
            firstname varchar(190) NOT NULL,
            lastname varchar(190) NOT NULL,
            firstname_kana varchar(255) NOT NULL,
            lastname_kana varchar(255) NOT NULL,
            birthday date NOT NULL,
            email varchar(255) NOT NULL,
            phone_number varchar(15) NOT NULL,
            password varchar(255) NOT NULL,
            postcode numeric(7) NOT NULL,
            prefecture varchar(10) NOT NULL,
            address1 varchar(100) NOT NULL,
            address2 varchar(100) NOT NULL,
            user_rank_id integer NOT NULL,
            memo text NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (user_rank_id) REFERENCES " . TABLE_USER_RANKS . "(id) 
             ON DELETE CASCADE
             ON UPDATE CASCADE
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
        DROP TABLE " . TABLE_USERS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
