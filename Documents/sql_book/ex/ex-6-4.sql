--016
select s.product_id
     , (sum(revenue) / sum(quantity))                                             as avg_pro
     , (select sum(s1.quantity) from sales s1 where s1.product_id = s.product_id) as sum_quantity
     , (select sum(s2.revenue) from sales s2 where s2.product_id = s.product_id)  as sum_revenue
     , (select sum(s3.revenue) * 1.0 / sum(s3.quantity) from sales s3)            as avg_unint
--     , (select sum( s2.revenue) / sum( s2.quantity) from sales s2 where s2.product_id = s.product_id )
from sales s
group by product_id
having (sum(revenue) / sum(quantity)) >
       (select sum(s3.revenue) / sum(s3.quantity) from sales s3)
order by avg_pro desc
;


--017
select *
from customers c
where prefecture in (select c.prefecture as cnt
                     from customers c
                     where c.is_premium = true
                     group by c.prefecture
                     having count(*) >= 4)
-- group by prefecture, user_id, name
order by birthday
limit 1
;

--018
select w.cid,
       (select count(max(l.session_count))
        from web_log l
        group by l.cid)
from web_log w
group by w.cid
;


--018
select count(*)       as session
     , sum(pageviews) as sum_pageviews
from (select cid, session_count, count(*) as pageviews
      from web_log l
      group by l.cid, session_count) st
;

--019
select sum(revenue)
from sales s
where s.is_proper = false
;

select (
               (select sum(revenue)
                from sales s
                where s.is_proper = true) -
               (select sum(revenue)
                from sales s
                where s.is_proper = false)
           )
;


--020
select sum(lost_revennue) as sum_lost_revenue
from (
    select *
           , quantity * (proper_unit_price - dicount_unit_price) as lost_revennue
    from (
         select *
              , revenue / quantity       as dicount_unit_price
              , (
              select sum(revenue) / sum(quantity)
                    from sales
                    where product_id = 1
                      and is_proper = true
                    ) as proper_unit_price
        from sales
        where product_id = 1
          and is_proper is false
        ) t2
) t1
