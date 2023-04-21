-- 050
select *
from products
where product_category = 'クッキー'
and product_name not like '%クッキー'
;

-- 051
select date_part('year',age(now(), birthday)), birthday
from customers
where birthday is not null
order by birthday desc
limit 1
;

-- 052
select date_part('year',age(TIMESTAMP '2019-12-31', birthday)), birthday
from customers
where birthday is not null
order by birthday desc
limit 1
;

-- 053
select  concat(product_category, '-', product_name), cost
from products
order by cost desc
limit 3
;

-- 054
select *
from sales
where product_id in (7,9,11)
and quantity >= 2
and is_proper = false
order by order_id
;

-- 055
select user_id, name, birthday
from customers
where date_part('dow', birthday) = 1
order by birthday
limit 1
;

-- 056
select name, birthday
from customers
where name like '川%'
and birthday is not null
order by birthday
limit 3
;

-- 057
select *
from sales
where to_char( date_time, 'MM-dd') = '01-01'
order by order_id
;

-- 058
select
    case
        when gender = 1 then
            concat(name,'様')
        when gender = 2 then
            concat(name,'さま')
    end as name_sama
from customers
order by register_date desc
limit 5
;

-- 059
select product_name, replace(product_name, 'ゼリー', 'ジュレ') as modified_name
from products
where product_name like '%ゼリー'
