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
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `staff_role_id` integer(11) NOT NULL,
            `memo` varchar(255) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`),
            FOREIGN KEY (`staff_role_id`) REFERENCES " . TABLE_STAFF_ROLES . "(`id`) 
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
        DROP TABLE " . TABLE_STAFFS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
