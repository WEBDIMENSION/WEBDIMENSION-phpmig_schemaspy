# DB構築 ER図作成

## Overview

DB設計・操作を目標とする

### ツール

- Docker, Docker-compose
    - phpmig
    - MySQL8
    - Postgres14
    - Schemaspy + Nginx
        - for MySQL
        - for Postgres

### 振る舞い

- phpmig
    - DDL を記述 `phpmig/migrationns/mysql` `phpmig/migrationns/postgres`
    - seeder,fakerでダミーデータ生成
- schemaspy
    - `docker-compose up -d` で起動、`depends_on:` でDBの起動依存
    - DB構造、リレーションなどを確認

## Usage

***portは.envで変更可***

### コンテナ起動

すべてのサービス起動

```bash
docker-compose up -d
```

---

## Theme

ECサイトのDBを想定

### Tables

| 用途     | Table名             | migration_prefix_number |
|--------|--------------------|-------------------------|
| 商品カテゴリ | product_categories | 008xxx                  |
| ログイン履歴 | login_history      | 007xxx                  |
| 受注商品   | orders_detail      | 014xxx                  |
| 受注明細   | orders_total       | 015xxx                  |
| 受注     | orders             | 013xxx                  |
| 支払い方法  | payment            | 004xxx                  |
| 商品レビュー | product_reviews    | 012xxx                  |
| 商品マスター | products           | 011xxx                  |
| 配送方法   | deliveries         | 003xxx                  |
| スタッフ権限 | staff_roles        | 001xxx                  |
| スタッフ   | staffs             | 002xxx                  |
| 顧客マスター | users              | 006xxx                  |
| 顧客権限   | users_ranks        | 005xxx                  |
| 商品ブランド | brands             | 010xxx                  |



## DB構築(DDL)をER図でチェックする。

- マイグレーションツール phpmig を使いDDLを記述
- Fakerを利用しダミーデータを投入
- 正規化できているか
- 外部キーは適切に設定されているか
- INDEXは適切に設定されているか
- schemaspyを利用しブラウザからヴィジュアルで確認できるようにする
    - 定義書
    - ER図

 ---

## Index

- [Index : http://localhost:49192/](http://localhost:49192/)



## phpmig

**Example Create Table**

```injectablephp
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

```injectablephp
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
