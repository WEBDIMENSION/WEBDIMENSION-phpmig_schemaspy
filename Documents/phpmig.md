# phpmig

## コマンド

```bash
#  migrationファイル作成
vendor/bin/phpmig generate
docker-compose exec phpmig vendor/bin/phpmig generate
# status
vendor/bin/phpmig status
docker-compose exec phpmig vendor/bin/phpmig status

# Migrate In Container
vendor/bin/phpmig migrate
#### mysql
docker-compose run --rm phpmig_mysql vendor/bin/phpmig migrate
#### postgres
docker-compose run --rm phpmig_postgres vendor/bin/phpmig migrate
````

## Rollback

```bash
## 1つ戻す 
vendor/bin/phpmig rollback
#### mysql
docker-compose exec phpmig_mysql vendor/bin/phpmig rollback
#### postgres
docker-compose exec phpmig_postgres vendor/bin/phpmig rollback

## 指定したところまで戻す 
vendor/bin/phpmig rollback -t 20111101000144
#### mysql
docker-compose exec phpmig_mysql vendor/bin/phpmig rollback -t 20111101000144
#### postgres
docker-compose exec phpmig_postgers vendor/bin/phpmig rollback -t 20111101000144

### 全て戻す
vendor/bin/phpmig rollback -t 0
#### mysql
docker-compose exec phpmig_mysql vendor/bin/phpmig rollback -t 0
#### postgres
docker-compose exec phpmig_postgers vendor/bin/phpmig rollback -t 0

### 指定したところを戻す
vendor/bin/phpmig phpmig down 20111101000144
##EE mysql
docker-compose exec phpmig_mysql vendor/bin/phpmig down 20111101000144
#### postgres
docker-compose exec phpmig_postgres vendor/bin/phpmig down 20111101000144
```

## Example Create Table

```php
<?php
use Phpmig\Migration\Migration;

class createStaffRoles extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        CREATE TABLE " . TABLE_STAFF_ROLES . " (
            `id` integer(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `memo` varchar(255) NOT NULL,
            `delete_flg` boolean NOT NULL DEFAULT false,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`)
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
        DROP TABLE " . TABLE_STAFF_ROLES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
```

**Example Insert Data**

```php
<?php

use Phpmig\Migration\Migration;

class insertStaffRoles extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();
        $staff_roles_array = STAFF_ROLES_ARRAY;

        for ($i = 0; $i < sizeof($staff_roles_array); $i++) {
            $stmt = $container['db']->prepare(
                "insert into " . TABLE_STAFF_ROLES . "
               (
                   name,
                   memo
               ) values (
                '" . $staff_roles_array[$i] . "',
                '" . $faker->realText(50) . "'
                );"
            );
            $stmt->execute([]);
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "
        TRUNCATE TABLE " . TABLE_STAFF_ROLES . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
```
