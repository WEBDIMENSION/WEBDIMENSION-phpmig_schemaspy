-- 090
select count(*) paeviews_8
from web_log
where page like '%/prod/prod_id_8/%'
;

-- 091
select sum(quantity) as sum_qty_14_15
from sales
where product_id in (14, 15)
;

-- 092
select round(sum(revenue) * 1.0 / count( distinct  order_id),-2) as avg_rev_by_order
from sales
;

-- 093
select order_id, sum(revenue) as total
from sales
group by order_id
order by total desc limit 1
;

-- 094
select
    sum(
            case
                when date_time < '2019-10-01 00:00:00' then
                    revenue * 1.08
                else
                    revenue * 1.1
                end
        )
from sales
;

-- 095
select sum(revenue)
from sales
where date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
;

-- 096
select cost, count(distinct product_id) as number_of_products
from products
where cost < 500
group by cost
;

-- 097
select count(*) as users
from customers
where birthday is null
and register_date is null
;

-- 098
select count(*)
from web_log
where page ~ 'prod/prod_id_\d\d?/$'
;

-- 099
select count(distinct order_id)
from sales
where
    to_char( date_time, 'MM') in ('01', '12')
