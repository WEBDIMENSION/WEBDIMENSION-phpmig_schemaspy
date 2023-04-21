-- 120
select prefecture, count(*) as cnt
from customers
where is_premium = true
   or gender = 1
group by prefecture
order by cnt desc
;

-- 121
select to_char(date_time, 'D'), to_char(date_time, 'Day'), to_char(date_time, 'HH24'), count(page) as pagevies
from web_log
group by to_char(date_time, 'D')
       , to_char(date_time, 'Day')
       , to_char(date_time, 'HH24')
having count(page) >= 60
order by pagevies desc
;

-- 122
select CASE
           WHEN cost <= 300 THEN 'a.300以下'
           WHEN cost <= 600 THEN 'b.301-600'
           WHEN cost <= 900 THEN 'c.601-900'
           ELSE 'd.901以上'
    END         AS cost_category
     , COUNT(*) AS number_of_products
from products
group by cost_category
order by cost_category
;

-- 123
select CASE
           WHEN prefecture in ('東京', '神奈川', '埼玉', '千葉') THEN '一都三県'
           ELSE '一都三県以外'
    END                                                           AS prefecuture_category
     , round(avg(date_part('year', age('2019-12-31', birthday)))) as ave_age
     , STDDEV_POP(date_part('year', age('2019-12-31', birthday))) AS stddev_age
from customers
group by prefecuture_category
;

-- 124
select max(c.name), sum(s.revenue) as sum_rev
from sales s
         join customers c on s.user_id = c.user_id
group by s.user_id
order by sum_rev desc
limit 3
;

-- 125
select count(*)
from (select count(session_count) session
      from web_log
      group by cid, session_count) as tbl
;

-- 126
select sum(quantity) as sum_quanntity
from sales s
         inner join customers c on s.user_id = c.user_id
    and c.gender = 2
;

-- 127
select c.prefecture, sum(quantity) as sum_qty
from sales s
         inner join customers c on s.user_id = c.user_id
group by c.prefecture
order by sum_qty
limit 3
;

-- 128
select p.product_category, sum(s.quantity), sum(revenue)
from sales s
         inner join products p on s.product_id = p.product_id
group by p.product_category
;

-- 129
select max(c.prefecture), sum(s.revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
group by c.user_id
order by sum_rev desc
limit 1
;
