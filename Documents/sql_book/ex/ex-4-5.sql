-- 006
select birthday, count(*) as cnt
from customers
where birthday is not null
group by birthday
having count(birthday) > 1
;

-- 002
select user_id, count(*) as pageviews
from web_log
where user_id is not null
  and media = 'email'
group by user_id
having count(*) >= 10
;

-- 008
select prefecture, count(user_id)
from customers
where is_premium = true
group by prefecture
having count(user_id) >= 10
;

--009
select cid, max(session_count) - min(session_count) + 1 as numbber_of_visits
from web_log
group by cid
order by numbber_of_visits desc
limit 3
;

--010
select case
           when cost >= 0 and cost < 300 then '1.価格帯 0-299'
           when cost >= 0 and cost < 600 then '2.価格帯 300-599'
           when cost >= 0 and cost < 900 then '3.価格帯 600-299'
           when cost >= 0 and cost < 1200 then '4.価格帯 900-1129'
    end as cost_range
,count( product_id) as item
from products
group by cost_range
order by cost_range
;
