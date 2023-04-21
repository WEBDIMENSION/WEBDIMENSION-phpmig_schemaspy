-- 140
select case
           when c.prefecture in ('東京', '埼玉', '千葉', '神奈川') then
               '東京圏'
           when c.prefecture in ('大阪', '京都', '奈良', '兵庫') then
               '大阪圏'
           else NULL
    end             as area
     , sum(revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
where c.prefecture in ('東京', '埼玉', '千葉', '神奈川', '大阪', '京都', '奈良', '兵庫')
group by area
order by sum_rev desc
;

-- 041
select date_part('year', age('2019-12-31', birthday)), sum(revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
where birthday is not null
group by date_part('year', age('2019-12-31', birthday))
order by sum_rev desc
limit 3
;

-- 042
select gender, is_premium, sum(revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
where c.prefecture = '東京'
group by gender, is_premium
order by gender, is_premium desc
;


-- 043
select case
           when is_premium = true then
               'premium'
           when is_premium = false then
               'standard'
           end
        ,
       case
           when is_premium = true then
               (select sum(revenue) as sum_rev
                from sales s
                         inner join customers c on s.user_id = c.user_id
                where is_premium = true
                group by c.user_id
                order by sum_rev desc
                limit 1)
           when is_premium = false then
               (select sum(revenue) as sum_rev
                from sales s
                         inner join customers c on s.user_id = c.user_id
                where is_premium = false
                group by c.user_id
                order by sum_rev desc
                limit 1)
           end
from customers
where is_premium is not null
group by is_premium
;


-- 044
select s.product_id, sum(revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
where date_part('year', age('2019-12-31', birthday)) >= 50
group by s.product_id
order by sum_rev desc
limit 3
;

-- 045
select case
           when gender = 1 then
               'male'
           when gender = 2 then
               'female'
    end                         as gender_cate
     , count(distinct order_id) as sum_orders
from sales s
         inner join customers c on s.user_id = c.user_id
group by gender
order by sum_orders desc
;

-- 046
select case
           when concat(to_char(register_date, 'YYYY'), '-', to_char(register_date, 'Q')) = '-' then
               '1916-4'
           else
               concat(to_char(register_date, 'YYYY'), '-', to_char(register_date, 'Q'))
    end             as register_q
     , sum(revenue) as sum_rev
from sales s
         inner join customers c on s.user_id = c.user_id
group by concat(to_char(register_date, 'YYYY'), '-', to_char(register_date, 'Q'))
order by sum_rev desc
limit 3
;

-- 047
select case
           when gender = 1 then
               'male'
           when gender = 2 then
               'female'
    end
     , sum(revenue) * 1.0 / count(distinct order_id) as avg_order_value
from sales s
         inner join customers c on s.user_id = c.user_id
group by gender
;

-- 048
SELECT case
           when gender = 1 then
               'male'
           when gender = 2 then
               'female'
    end
     , AVG(orders) AS avg_order
FROM (SELECT s.user_id
           , c.gender
           , COUNT(DISTINCT order_id) AS orders
      FROM sales s
               join customers c on s.user_id = c.user_id
      GROUP BY c.gender, s.user_id) tbl
GROUP BY gender
;

-- 049
select sum(revenue) * 1.0 / sum(quantity) as avg_uit_proce_1
     , (select sum(revenue) * 1.0 / sum(quantity)
        from sales)                       as avg_unit_price_all
     , sum(revenue) * 1.0 / sum(quantity) /
       (select sum(revenue) / sum(quantity)
        from sales)                       as diff

from sales
where product_id = 1
group by product_id
