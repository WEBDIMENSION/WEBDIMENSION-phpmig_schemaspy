-- 110
select to_char(date_time, 'YYYY') as year, count(distinct user_id) as users
from sales
group by to_char(date_time, 'YYYY')
order by year
;

-- 111
select to_char(date_time, 'YYYY-MM-DD') as date, count(page) as pageviews
from web_log
group by to_char(date_time, 'YYYY-MM-DD')
order by pageviews desc, to_char(date_time, 'YYYY-MM-DD') desc
;

-- 112
select to_char(date_time, 'HH24') as hour, count(page) as pageviews
from web_log
group by to_char(date_time, 'HH24')
order by pageviews desc
limit 3
;

-- 113
select media, count(page) as pagevies
from web_log
where page not like '/prod/%'
group by media
order by pagevies desc
;

-- 114
select  session_count, count(distinct cid) as users
from web_log
where device = 'mobile'
    and session_count = 1
group by session_count
;

-- 115
select prefecture, count(user_id) as users
from customers
where register_date is null
group by prefecture
order by  users desc
limit 3
;

-- 116
select prefecture, count(distinct user_id) as premium_users
from customers
where is_premium = true
group by prefecture
order by premium_users desc
limit 3
;

-- 117
select SPLIT_PART(name ,' ', 1) as last_name, count(user_id) as cnt
from customers
where gender = 2
group by SPLIT_PART(name ,' ', 1)
having count(user_id) >= 3
order by cnt desc
;

-- 118
select to_char(date_time, 'Month') as month
    , sum(session_count) as session
from web_log
group by to_char(date_time, 'Month')
limit 3
;

-- 119
select count(distinct user_id) as users
     , count(distinct order_id) as orders
     , round(count(distinct order_id) * 1.0 / count(distinct user_id) * 1.0, 2)  as avg_orders
from sales
order by avg_orders desc
