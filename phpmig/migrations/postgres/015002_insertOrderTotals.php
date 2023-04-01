<?php

use Phpmig\Migration\Migration;

class insertOrderTotals extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $faker = Faker\Factory::create(FAKER_LOCATE);
        $container = $this->getContainer();

        $stmt = $container['db']->query("
        select o.order_id, count(od.order_id), sum(od.product_price * od.product_quantity) as sub_total, o.created_at, o.updated_at
        from
             orders o left join order_details od
            on o.order_id = od.order_id
        group by o.order_id, od.order_id, o.created_at, o.updated_at
            ");
        $order_details_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $container['db']->query("SELECT * FROM " . TABLE_DELIVERIES);
        $delivery_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = $container['db']->query("SELECT * FROM " . TABLE_PAYMENTS);
        $payment_array = $stmt->fetchAll(PDO::FETCH_ASSOC);


        for ($i = 0; $i < count($order_details_array); $i++) {
            $order_id = $order_details_array[$i]['order_id'];
            $sub_total = $order_details_array[$i]['sub_total'];

            $total_value = 0;
            $total_value += $order_details_array[$i]['sub_total'];

            $delivery = $faker->randomElement($delivery_array);
            $delivery_id = $delivery['id'];
            $delivery_name = $delivery['delivery_name'];
            $delivery_cost = $delivery['delivery_cost'];
            $total_value += $delivery['delivery_cost'];

            $payment = $faker->randomElement($payment_array);
            $payment_id = $payment['id'];
            $payment_name = $payment['payment_name'];
            $payment_cost = $payment['payment_cost'];
            $total_value += $payment['payment_cost'];

            $created_at = $order_details_array[$i]['created_at'];
            $updated_at = $order_details_array[$i]['updated_at'];


            $stmt = $container['db']->prepare(
                "insert into " . TABLE_ORDER_TOTALS . "
                        (
                            order_id,
                            sub_total,
                            delivery_id,
                            delivery_name,
                            delivery_cost,
                            payment_id,
                            payment_name,
                            payment_cost,
                            order_total,
                            created_at,
                            updated_at
                        ) values (
                         '" . $order_id . "',
                         '" . $sub_total . "',
                         '" . $delivery_id . "',
                         '" . $delivery_name . "',
                         '" . $delivery_cost . "',
                         '" . $payment_id . "',
                         '" . $payment_name . "',
                         '" . $payment_cost . "',
                         '" . $total_value . "',
                         '" . $created_at . "',
                         '" . $updated_at . "'
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
        TRUNCATE TABLE " . TABLE_ORDER_TOTALS . "
        ";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
