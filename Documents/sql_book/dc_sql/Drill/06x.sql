-- 060
select user_id, name
from customers
where
    length(SPLIT_PART(name ,' ', 1)) = 3
    and length(SPLIT_PART(name ,' ', 2)) = 3
;

-- 061
select page , replace(page,'?sys=abc123','') page_without_parameter

from web_log
where page like '%?sys=abc123'
order by date_time
limit 3
;

-- 062
select page, substring(page,'prod/prod_id_(\d\d?)/')
from web_log
where STRPOS(page, '/prod/') > 0
order by date_time
limit 5
;


-- 063
select concat(product_category, '-', product_name) as cate_prod
, length(concat(product_category, '-', product_name)) as length
from products
order by length desc
limit 3
;


-- 064
select name, prefecture, register_date, to_char(register_date + cast( '10 years' as INTERVAL ), 'YYYY-MM-DD')
from customers
where prefecture in ('千葉')
and register_date is not null
order by register_date
;

-- 065
select user_id, name, birthday, register_date, date_part('year',age(now(), birthday)) as register_age
from customers
where  birthday is not null
   and register_date is not null
order by register_age
limit 1
;

-- 066
select count(*)
from web_log
;

-- 067
select avg(cost) as avg_cost
from products
;

-- 068
select max(cost) as max_cost
from products
;

-- 069
select max(revenue) as max_revenue
from sales
;
