-- 031
select *
from customers
where name like '山%子'
;

-- 032
select *
from customers
order by random()
limit 3
;

-- 033
select corr(quantity,revenue) as corr
from sales
;

-- 034
select
    STDDEV_POP(cost) AS std_dev_cost
from products
;

-- 035
select *
from sales
order by date_time
limit 1
;

-- 036
select order_id, user_id, revenue
from sales
order by revenue desc
limit 1
;

-- 037
select *
from sales
where product_id = 5
    and revenue >= 8000
order by order_id
;

--038
select date_time
from web_log
where media = 'cpc'
order by date_time
limit 1
;

-- 039
select date_time
from sales
where is_proper = false
order by date_time
limit 1
