-- --------------------
--  staffs
-- --------------------

-- staff一覧
explain
select s.id, s.name, sr.name
from staffs s
         inner join staff_roles sr on s.staff_role_id = sr.id
where s.delete_flg = false
;

-- 受注データから担当者指定
explain
select s.name, o.*
from orders o
         inner join staffs s
                    on o.staff_id = s.id
--     and s.id = 7
where s.id = 7
;

-- subquery
explain
select o.*
from orders o
where o.staff_id = (select id from staffs where id = 7)
;

-- 担当している受注数
explain
select o.staff_id
     , s.name
     , count(o.staff_id)                                          as count
     , (select count(id) from orders as total_count)              as total_order_count
     , TRUNCATE( (count(o.staff_id) / (select count(id) from orders) * 100), 1) as percennt

from orders o
         join staffs s on s.id = o.staff_id
group by o.staff_id, s.name
order by count DESC
;

-- subquery
explain
select o.staff_id
     , (select s.name from staffs s where s.id = o.staff_id) as name -- <-subquery
     , count(o.staff_id)                                     as count
     , (select count(id) from orders as total_count)              as total_order_count
     , TRUNCATE( (count(o.staff_id) / (select count(id) from orders) * 100), 1) as percennt
from orders o
group by o.staff_id
order by count desc
;

-- window functions
explain
select max(o.staff_id) over (partition by staff_id)                    as staff_id
     , ROW_NUMBER() OVER (PARTITION BY o.staff_id ORDER BY o.order_id) AS num
     , o.order_id
     , count(o.id) over (partition by staff_id)                        as count
     , (select count(id) from orders)                                  as total_order_count
     , TRUNCATE(
               (count(o.id) over (partition by staff_id)
                   /
                (select count(id) from orders)
                   )
            * 100
           , 1)
                                                                       as percennt
from orders o
;
-- --------------------
--  users
-- --------------------

-- user 一覧
explain
select u.id, ur.user_rank_name, u.lastname, u.firstname, u.email
from users u
         inner join user_ranks ur
                    on u.user_rank_id = ur.id
order by u.id
;

-- 受注履歴
explain
select u.id, u.lastname, u.firstname, u.email, o.order_id
from users u
         inner join orders o on u.id = o.user_id
order by o.order_id
;

-- ログイン履歴
explain
select u.id, u.lastname, u.firstname, u.email, lh.date, lh.ua, lh.ipv4
from users u
         inner join login_histories lh on u.id = lh.user_id
;

-- review 履歴
explain
select u.id, u.lastname, u.firstname, u.email, pr.product_id, pr.content, pr.review_valuation
from users u
         inner join product_reviews pr on u.id = pr.user_id
order by u.id
;

-- --------------------
--  products
-- --------------------

-- products 一覧
explain
select p.id, product_code, p.product_name, p.product_price, p.product_stock, pc.category_name, b.brand_name
from products p
         inner join product_categories pc on pc.id = p.category_id
         inner join brands b on p.brand_id = b.id
;

--  products review
explain
select pr.id, product_name, pr.content, pr.review_valuation
from product_reviews pr
         inner join products p on pr.product_id = p.id
;

-- --------------------
--  orders
-- --------------------
-- 明細
explain
select o.order_id,
       o.user_id,
       ot.sub_total,
       ot.delivery_name,
       ot.delivery_cost,
       ot.payment_name,
       ot.payment_cost,
       o.lastname,
       o.firstname,
       o.email,
       ur.user_rank_name,
       s.name,
       od.product_id,
       od.product_code,
       od.shop_product_code,
       od.product_name,
       od.product_price,
       od.product_quantity,
       pc.category_name,
       b.brand_name
from orders o
         inner join order_details od on o.order_id = od.order_id
         inner join order_totals ot on od.order_id = ot.order_id
         inner join user_ranks ur on o.user_rank_id = ur.id
         inner join staffs s on o.staff_id = s.id
         inner join product_categories pc on o.delete_flg = pc.delete_flg
         inner join brands b on od.brand_id = b.id
order by o.user_id
;

-- 合計
explain
select o.order_id, o.sub_total, o.order_total, o.delivery_name, o.delivery_cost, o.payment_name, o.payment_cost
from order_totals o
;


-- ----------------------

select count(*)
from login_histories
;

explain
select *
from users;

explain
select *
from users
where id = 50;

explain
select *
from users
where lastname = '江古田';

select u.lastname, u.firstname, r.user_rank_name
from users u
         left join user_ranks r
                   on u.user_rank_id = r.id;
explain
select u.lastname, u.firstname, r.user_rank_name
from users u
         left join user_ranks r
                   on u.user_rank_id = r.id;


explain
select count(*)
from orders;

explain
select o.order_id, o.user_id, o.lastname, o.firstname, ur.user_rank_name
from orders o
         left join user_ranks ur
                   ON o.user_id = ur.id
;


select *
from users u
where u.user_rank_id is null
;

select *
from users u
where u.user_rank_id is not null
;


explain
select o.order_id, o.user_id, o.lastname, o.firstname, ur.user_rank_name
from orders o
         inner join users u
                    on o.user_id = u.id
         inner join user_ranks ur
                    on u.`user_rank_id` = ur.id
where user_rank_name = 'premium'
;

explain
select o.order_id, u.id, ur.user_rank_name
from user_ranks ur
         inner join users u
                    on ur.id = u.`user_rank_id`
                        and ur.user_rank_name = 'premium'
         inner join orders o
                    on u.id = o.`user_id`
;



explain
select ur.user_rank_name
from user_ranks ur
         left join users u
                   on ur.id = u.user_rank_id
where ur.user_rank_name = 'premium'
;

explain
select ot.order_id, d.delivery_name
from order_totals ot
         left join deliveries d on ot.delivery_id = d.id
where ot.delivery_id = 1
;


explain
select ot.order_id, ot.delivery_name, d.delivery_name
from deliveries d
         inner join order_totals ot on d.id = ot.delivery_id
    and d.id = 1
;


select count(*)
from order_totals ot
where ot.delivery_id = 1
;
