-- 100
select count(distinct user_id)
from customers
where to_char(birthday, 'YYYY-MM-dd') like '198%'
;

-- 101
select prefecture, count(user_id) cnt
from customers
group by prefecture
order by cnt desc
limit 3
;

--102
select count(distinct user_id)
from customers
where register_date between '2019-01-01 00:00:00' and '2019-03-31 23:59:59'
;

-- 103
select trunc(cast((sum(revenue) / count(distinct to_char(date_time, 'YYYY-MM-dd')) * 1.0 / 100 + 1) as numeric)) *
       100 as cnt
from sales
order by cnt desc
;

-- 104
select to_char(date_time, 'YYYY-AM') as sales_time, sum(revenue)
from sales
group by to_char(date_time, 'YYYY-AM')
order by sales_time
;

-- 105
select round(avg(date_part('year', age('2019-12-31', birthday))))
from customers
where prefecture = '千葉'
  and gender = 2
  and birthday is not null
;

-- 106
select sum(
               case
                   when product_id = 1 and quantity = 1 then
                       2000
                   else
                       revenue
                   end
           ) as msr
from sales
;

-- 107
select cast(avg(cost) as integer) avg_cost
from products
group by product_category
order by avg_cost desc
;

-- 108
select sum(revenue)
from sales
where product_id = 5
    and to_char(date_time, 'YYYY') in ('2019')
;

--109
select to_char(date_time, 'YYYY') as year, round(avg(quantity),2)
from sales
group by to_char(date_time, 'YYYY')
order by year
;
