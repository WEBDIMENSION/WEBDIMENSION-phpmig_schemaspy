-- 070
select sum(revenue) as sum_revenue
from sales
;

-- 071
select sum(quantity) as sum_quantity
from sales
;

-- 072
select count(distinct cid)
from web_log
;

-- 073
select count(distinct order_id)
from sales
;

-- 074
select count(distinct user_id)
from sales
;

-- 075
select max(date_time)
from web_log
;

-- 076
select count(distinct product_id) as items
from sales
;

-- 077
select (revenue / 1.1) as revenue_without_tax
from sales
;

--078
select count(distinct media)
from web_log
;

-- 079
select sum(revenue)
from sales
where product_id = 1
;
