--021
select name, SPLIT_PART(name ,' ', 1) as family_name
     , SPLIT_PART(name ,' ', 2) as first_nname
from customers
limit 5
;

--022
select s.product_id, round(sum(s.revenue),-3) as sum_revenue
from sales s
group by s.product_id
order by sum_revenue desc
limit 5
;

--023
select concat(name, keisho )  as name_with_keishou
    , birthday
    , age
from (
   select name, birthday
   , date_part('year',age(TIMESTAMP '2019-12-31', birthday)) as age
   , CASE
       when date_part('year',age(TIMESTAMP '2019-12-31', birthday)) >= 50 then 'さま'
       else
        'さん'
     END as keisho
    from customers
        where birthday is not null
     ) tbl
where name ~ '(美馬|森村)'
order by birthday
;

--024
select to_char(date_time,'YYYY/MM') as year_month
    , count(page) as page_view
from web_log
group by year_month
order by page_view desc
limit 3
;

--025
select name, SPLIT_PART(name ,' ', 2) as first_name
from customers
where SPLIT_PART(name ,' ', 1) ~ '川$'
    and  SPLIT_PART(name ,' ', 2) ~ '(..子)'
