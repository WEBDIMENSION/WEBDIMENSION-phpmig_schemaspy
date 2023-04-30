-- 170
select count(*)
from web_log
where page = '/thank_you/'
;

-- 171
select round(cast(avg(date_part('year', age('2019-12-31', birthday))) as numeric), 0)
from customers
where date_part('year', age('2019-12-31', birthday)) >=
      (select round(cast(avg(date_part('year', age('2019-12-31', birthday))) as numeric), 0)
       from customers
       where birthday is not null)
;

-- 172
select SPLIT_PART(name, ' ', 2) as first, count(SPLIT_PART(name, ' ', 2)) as cnt
from customers
group by first
having count(SPLIT_PART(name, ' ', 2)) >= 3
order by cnt desc
;

-- 173
select prefecture,
       sum(s.revenue),
       sum(s.revenue) * 100.0 / (select sum(ss.revenue)
                                 from sales ss) as per
from sales s
         join customers c on s.user_id = c.user_id
group by c.prefecture
order by per desc
limit 3
;

-- 174
select count(distinct user_id)
--     *
from (select user_id
           , product_id
           , case
                 when product_id = 1 then
                     1
                 else
                     0
        end as p1
           , case
                 when product_id = 2 then
                     1
                 else
                     0
        end as p2

      from sales
      group by user_id, product_id
      order by user_id) tbl
group by user_id
having sum(p1) >= 1
   and sum(p2) >= 1
;

-- 175
select order_id,
       sum(revenue),
       sum(revenue) * 1.0 /
       (select sum(revenue)
        from sales
        group by order_id
        order by sum(revenue) desc
        limit 1) sum_rev
from sales
group by order_id
order by sum_rev desc
limit 5
;

-- 176
select count(user_id)
from (select user_id

      from (select user_id
                 , order_id
                 , case
                       when product_id = 1 then
                           1
                       else
                           0
              end as p1
                 , case
                       when product_id = 2 then
                           1
                       else
                           0
              end as p2

            from sales
            group by user_id, order_id, product_id
            order by user_id, order_id) tbl
      group by user_id, order_id
      having sum(p1) >= 1
         and sum(p2) >= 1) tbl2
;

-- 177
select user_id, count(page)
from web_log
where page = '/thank_you/'
group by cid, user_id
having count(page) > 1
order by user_id
;

-- 178
select s.user_id, c.name
from sales s
         join customers c on s.user_id = c.user_id
group by s.order_id, s.user_id, c.name, s.product_id
having count(s.product_id) > 1
;

-- 179
select count(page) * 1.0 /
       (select sum(sc)
        from (select max(session_count) as sc
              from web_log
              group by cid) tbl) tbl2

from web_log
where page = '/thank_you/'
;

---

SELECT SUM(cv)                      AS cv
     , COUNT(*)                     AS session
     , ROUND(SUM(cv * 1.0) / COUNT(*), 4) AS cvr
FROM (
SELECT cid
           , session_count
           , MAX(cv_page) AS cv
      FROM (
      SELECT *
                 , case
                       when page like '/thank_you/' then
                           1
                       else
                           0
              end as cv_page
            FROM web_log
            ) tbl
      GROUP BY cid
             , session_count
      ) tbl2
