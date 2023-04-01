<?php

use Phpmig\Migration\Migration;

class createStaffs extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_STAFFS . " (
            id SERIAL NOT NULL,
            name varchar(50) NOT NULL,
            staff_role_id integer NOT NULL,
            memo varchar(255) NOT NULL,
            delete_flg boolean NOT NULL DEFAULT false,
            created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (staff_role_id) REFERENCES " . TABLE_STAFF_ROLES . "(id) 
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
        DROP TABLE " . TABLE_STAFFS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
