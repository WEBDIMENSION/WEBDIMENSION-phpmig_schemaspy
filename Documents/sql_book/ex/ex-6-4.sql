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
select sum(ts2.discounnt)
from (select sum(ts.quantity) * ts.unit as discounnt
      from (select *
                 , s.revenue / s.quantity as unit
            from sales s
            where s.product_id = 1
              and is_proper = false) ts
      group by unit) ts2
;

-- select ((s.revenue / s.quantity)
--            -
--             (select s2.revenue / s2.quantity as price
--              from sales s2
--              where s2.product_id = 1
--                and s2.is_proper = false
--              limit 1)
--         )
--            *
--        (select sum(s3.quantity)
--         from sales s3
--         where s3.product_id = 1
--           and s3.is_proper = false)
--
-- from sales s
-- where product_id = 1
--   and is_proper = true
-- ;
