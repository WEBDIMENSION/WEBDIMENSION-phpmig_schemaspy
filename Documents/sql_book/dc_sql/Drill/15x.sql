-- 150
select case
           when prefecture in ('東京') then
               '東京'
           when prefecture in ('千葉', '埼玉', '神奈川') then
               '南関東'
           when prefecture in ('茨城', '栃木', '群馬') then
               '北関東'
    end as region
     , round(cast(avg(date_part('year', age('2019-12-31', birthday))) as numeric), 1)
from customers
where prefecture in ('東京', '千葉', '埼玉', '神奈川', '茨城', '栃木', '群馬')
group by region
;

--151
select product_id
     , sum(quantity)                                                                               as sum_qty
     , sum(revenue)                                                                                as sum_rev
     , (select count(page) from web_log where page ~ concat('^/prod/prod_id_', s.product_id, '/')) as pageviews
from sales s
group by product_id
order by pageviews desc
limit 3
;


-- 152
select tbl_2019.quarter, (tbl_2019.sum_rev * 1.0 / tbl_2018.sum_rev) as growth_rate
from (select to_char(date_time, 'Q') as quarter, sum(revenue) as sum_rev
      from sales
      where date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
      group by to_char(date_time, 'Q')
      order by quarter) tbl_2019
         join
     (select to_char(date_time, 'Q') as quarter, sum(revenue) as sum_rev
      from sales
      where date_time between '2018-01-01 00:00:00' and '2018-12-31 23:59:59'
      group by to_char(date_time, 'Q')
      order by quarter) tbl_2018
     on tbl_2019.quarter = tbl_2018.quarter
;

--153
select name, user_age
from (select s.user_id, name, date_part('year', age('2019-12-31', birthday)) as user_age
      from sales s
               join customers c on s.user_id = c.user_id
      where date_time between '2017-01-01 00:00:00' and '2017-12-31 23:59:59'
      group by s.user_id, name, birthday
      INTERSECT
      select s.user_id, name, date_part('year', age('2019-12-31', birthday)) as user_age
      from sales s
               join customers c2 on s.user_id = c2.user_id
      where date_time between '2018-01-01 00:00:00' and '2018-12-31 23:59:59'
      group by s.user_id, name, birthday
      INTERSECT
      select s.user_id, name, date_part('year', age('2019-12-31', birthday)) as user_age
      from sales s
               join customers c3 on s.user_id = c3.user_id
      where date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
      group by s.user_id, name, birthday
      order by user_age) tbl
order by user_age
limit 3
;

-- 154
select product_id
from (select product_id
      from sales
      where date_time between '2017-01-01 00:00:00' and '2017-12-31 23:59:59'
      group by product_id
      having sum(revenue) >= 100000
      INTERSECT
      select product_id
      from sales
      where date_time between '2018-01-01 00:00:00' and '2018-12-31 23:59:59'
      group by product_id
      having sum(revenue) >= 200000
      INTERSECT
      select product_id
      from sales
      where date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
      group by product_id
      having sum(revenue) <= 200000) tbl
;

-- 155
select *
from (select prefecture
      from sales s
               join customers c on s.user_id = c.user_id
      where s.date_time between '2017-01-01 00:00:00' and '2017-12-31 23:59:59'
      group by prefecture
      having sum(revenue) / count(distinct order_id) <= 2000
      INTERSECT
      select prefecture
      from sales s
               join customers c on s.user_id = c.user_id
      where s.date_time between '2018-01-01 00:00:00' and '2018-12-31 23:59:59'
      group by prefecture
      having sum(revenue) / count(distinct order_id) >= 6000
      INTERSECT
      select prefecture
      from sales s
               join customers c on s.user_id = c.user_id
      where s.date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
      group by prefecture
      having sum(revenue) / count(distinct order_id) >= 6000) tbl
;

-- 156
-- todo
select tbl17.user_id, sum_rev_17, sum_rev_18, sum_rev_19, sum_rev_17 + sum_rev_18 + sum_rev_19 as ttl_sum_rev
from (select user_id, sum(revenue) as sum_rev_17
      from sales s17
      where s17.date_time between '2017-01-01 00:00:00' and '2017-12-31 23:59:59'
      group by user_id) tbl17
         join
     (select user_id, sum(revenue) as sum_rev_18
      from sales s18
      where s18.date_time between '2018-01-01 00:00:00' and '2018-12-31 23:59:59'
      group by user_id) tbl18
     on tbl17.user_id = tbl18.user_id
         join
     (select user_id, sum(revenue) as sum_rev_19
      from sales s18
      where s18.date_time between '2019-01-01 00:00:00' and '2019-12-31 23:59:59'
      group by user_id) tbl19
     on tbl17.user_id = tbl19.user_id
where tbl18.sum_rev_18 > tbl17.sum_rev_17
  and tbl19.sum_rev_19 > tbl18.sum_rev_18
order by ttl_sum_rev desc
limit 3
;

-- 167
select count(distinct user_id) as users
from sales
where product_id = 7
;

-- 158
SELECT COUNT(*) AS orders
FROM (SELECT order_id
           , COUNT(DISTINCT is_proper) AS mix_flag
      FROM sales
      GROUP BY order_id
      HAVING COUNT(DISTINCT is_proper) > 1) tbl
;

-- 159
select round( cast(avg(age) as numeric),1)
from (select date_part('year', age('2019-12-31', birthday)) as age
      from customers) tbl
