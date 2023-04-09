select *
from users
;


explain
select 1
from staffs s
where not exists(
        select *
        from staff_roles sr
        where s.id = sr.id
    )
;

select *
from staffs
;
select *
from staff_roles
;

-- 受注数順
explain
select o.user_id
     , u.lastname
     , u.firstname
     , count(o.user_id) as cnt
from users u
         inner join orders o On u.id = o.user_id
group by o.user_id, u.lastname, u.firstname
order by cnt desc
;

-- 受注金額順
explain
select o.user_id
     , count(ot.sub_total) as cnt
     , sum(ot.sub_total)   as sub_total
     , ot.payment_name
     , u.firstname
     , u.lastname
from orders o
         inner join order_totals ot on o.order_id = ot.order_id
--                 and ot.delivery_id = 1 -- 配送指定
--                 and ot.payment_id = 1 -- 支払い指定
         left join users u
                   on u.id = o.user_id
group by o.user_id, u.firstname, u.lastname, ot.payment_name
order by sub_total desc
;

-- 多くの受注持つスタッフ
explain
select
    o.staff_id
    , s.name
    , count(o.id)
from orders o
    right join staffs s on o.staff_id = s.id
group by s.name, o.staff_id
order by o.staff_id
