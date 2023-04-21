-- 130
select max(sum_rev), min(sum_rev), avg(sum_rev)
from (select sum(revenue) as sum_rev
      from sales
      group by user_id) tbl
;

-- 131
select date_part('year', age('2019-12-31', birthday)), count(user_id) as users
from customers
where birthday is not null
  and gender = 1
group by date_part('year', age('2019-12-31', birthday))
order by count(user_id) desc
limit 3
;

-- 132
WITH master AS (SELECT cid
                     , MAX(user_id) AS user_id2
                FROM web_log
                GROUP BY cid)
SELECT user_id2
     , COUNT(*) AS pageview
FROM web_log
         JOIN master
              USING
                  (cid)
GROUP BY user_id2
HAVING user_id2 IS NOT NULL
ORDER BY pageview DESC
LIMIT 3
;

-- 133
select p.product_name, sum(s.revenue) as sum_rev
from customers c
         left join sales s on c.user_id = s.user_id
    and prefecture = '東京'
         left join products p on s.product_id = p.product_id
where product_name is not null
group by p.product_name
order by sum_rev desc
limit 3
;

-- 134
select avg(date_part('year', age('2019-12-31', c.birthday))), sum(s.revenue) as sum_rev
from customers c
         right join sales s on c.user_id = s.user_id
    and c.gender = 1
where c.user_id is not null
group by s.user_id, c.birthday
order by sum_rev desc
limit 1
;

-- 135
select (select count(page)
        from web_log w1
        where page like '%/thank_you/%') as cv
     , (select count(page)
        from web_log w1
        where page like '%/cart/%')      as cart
     , (select count(page)
        from web_log w1
        where page like '%/thank_you/%') * 1.0 /
       (select count(page)
        from web_log w1
        where page like '%/cart/%')      as cart
;

-- 136
select count(distinct order_id) as orders
     , sum(revenue)             as sum_rev
     , sum(revenue) * 1.0 / count(distinct order_id)
from sales
;

-- 137
WITH
    user19 AS (
        SELECT user_id
        FROM sales
        WHERE EXTRACT(YEAR FROM date_time) = 2019
        GROUP BY user_id
    )
SELECT user_id
FROM
    (
        SELECT user_id
        FROM sales
        GROUP BY user_id

    ) all_user
EXCEPT
DISTINCT
(
    SELECT user_id
    FROM sales
    WHERE EXTRACT(YEAR FROM date_time) = 2019
    GROUP BY user_id
)
ORDER BY user_id
LIMIT 10

-- 138
select to_char( date_time, 'Day') day_of_week
     , count(page) as sum_pv
from web_log
group by
    to_char( date_time, 'D')
       ,to_char( date_time, 'Day')
order by  to_char( date_time, 'D')
;

--139
select c.prefecture, sum(s.revenue) * 1.0 / count(s.quantity) as avg
from sales s left join customers c on s.user_id = c.user_id
group by c.prefecture
order by avg desc
limit 3
;

SELECT
    prefecture
     , SUM(sum_rev) / SUM(sum_qty) AS avg_unit_price
FROM
    (    SELECT
             user_id
              , SUM(revenue) AS sum_rev
              , SUM(quantity) AS sum_qty
         FROM
             sales
         GROUP BY
             user_id
    ) tbl
        JOIN customers
             USING
                 (user_id)
GROUP BY
    prefecture
ORDER BY
    avg_unit_price DESC
LIMIT 3
