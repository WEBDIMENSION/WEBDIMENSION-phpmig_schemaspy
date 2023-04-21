-- 080
select count(session_count)
from web_log
where session_count = 1
;

-- 081
select count(distinct product_category)
from products
;

-- 082
select count(product_id)
from products
where cost <= 300
;

-- 083
select sum(revenue) / count(distinct user_id)
from sales
;

-- 084
select date_part('day',max(date_time) - min(date_time))
from web_log
;

-- 085
select device, count(page) as page_views
from web_log
group by device
order by page_views desc
;


-- 086
select count(*)
from customers
where prefecture != '東京'
;

-- 087
select count(*) as users
from customers
where register_date is null
;

-- 088
select count( distinct to_char( date_time, 'YYYY-MM-dd'))
from web_log
;

-- 089
select page, count(page) as pageviews
from web_log
group by page
order by pageviews desc
limit 5
;
