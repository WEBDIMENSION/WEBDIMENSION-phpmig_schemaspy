-- 011
select p.product_category, sum(s.revenue) as sum
from sales s
         left join products p on s.product_id = p.product_id
group by p.product_category
order by sum desc
;


--012
select s.product_id
     , sum(s.quantity)                                           as quantity
     , (select sum(quantity) from sales)
     , sum(s.quantity) * 1.0 / (select sum(quantity) from sales) as share
from sales s
group by s.product_id
order by share desc
;

---013
select case
           when c.gender = 1 then '男性'
           when c.gender = 2 then '女性'
           else '不明'
    end               as gender
     , p.product_category
     , sum(s.revenue) as sum
from sales s
         left join products p on s.product_id = p.product_id
         left join customers c On s.user_id = c.user_id
group by c.gender, p.product_category
order by gender, sum desc
;

--014
select s.product_id
from sales s
where s.date_time between '2019-07-01' and '2019-09-30'
group by s.product_id
having sum(s.quantity) >= 10
except
distinct
select s.product_id
from sales s
where s.date_time between '2019-10-01' and '2019-12-31'
group by s.product_id
having sum(s.quantity) >= 10
;

--015
select p.product_name
     , sum(s.quantity) as sum_quantity
     , sum(s.revenue) as sum_revinue
     , sum(s.quantity) * max(p.cost) as sum_cost
     , sum(s.revenue) - (sum(s.quantity) * max(p.cost)) as profit
from sales s
         inner join products p on s.product_id = p.product_id
group by p.product_name
order by profit desc
limit 3
;
