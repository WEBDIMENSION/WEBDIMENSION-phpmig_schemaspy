-- 040
select *
from customers
order by birthday
limit 1
;

-- 041
select
    var_pop(cost) AS var_cost
from  products
where product_category != 'ゼリー'
;

-- 042
select user_id
from sales
where
--     order_id % 3 = 0
--     and order_id % 7 = 0
    MOD(order_id, 3) = 0
AND MOD(order_id, 7) = 0
order by user_id
limit 1
;

-- 043
select to_char(max(date_time),'YYYY-MM-DD') as newest_date
from sales
;

-- 044
select *
from customers
where name like '%子'
    and birthday is not null
order by birthday
limit 1
;

-- 045
select *
from customers
where to_char( birthday, 'MM-dd') = to_char( register_date, 'MM-dd')
;

-- 046
select *
from customers
where prefecture in ('福岡', '佐賀', '長崎')
    and is_premium = true
order by user_id
;

-- 047
select *
from sales
where date_time between '2017-02-01 00:00:00' and '2017-02-17 23:59:59'
order by revenue desc
limit 1
;

-- 048
select user_id, name
from customers
where SPLIT_PART(name ,' ', 1) like '%山'
    and gender = 1
;

-- 049
select name, birthday, register_date
from customers
where birthday is null
and register_date is not null
;
