<?php

use Phpmig\Migration\Migration;

class CreateUserRanks extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_USER_RANKS . " (
            id SERIAL NOT NULL,
            user_rank_name varchar(50) NOT NULL,
            memo varchar(50) NOT NULL,
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
        DROP TABLE " . TABLE_USER_RANKS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
