-- 001
select *
     , revenue * 1.1 as revenue_tax
from sales
order by order_id
limit 3
;

--002
select order_id
     , quantity
     , quantity + 1                          as new_qty
     , revenue
     , (revenue / quantity) * (quantity + 1) as new_revenue
from sales
order by new_revenue desc
limit 3
;

--003
select *
from customers
where birthday is not null
  and is_premium = true
order by birthday desc, register_date
limit 3
;

--004
select *
from customers
where (
            is_premium = true
        or birthday between '1970-01-01' and '1979-12-31'
    )
  and name like '%美'
order by birthday
limit 3
;


--005
select *
from customers
where prefecture not in ('東京', '千葉', '埼玉', '神奈川')
  and is_premium = true
order by birthday desc
limit 3
;
