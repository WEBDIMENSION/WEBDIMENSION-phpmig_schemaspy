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


-- 多くの受注持つスタッフ
explain
select o.staff_id
     , s.name
     , count(o.id)
from orders o
         right join staffs s on o.staff_id = s.id
group by s.name, o.staff_id
order by o.staff_id
;

-- Staff 単位 受注金額
explain
select o.staff_id
     , s.name
--      , ot.sub_total
     , to_char(count(ot.order_id), 'fm999,999,999,999')   as cnt
     , (select to_char(count(ot2.sub_total) / count(DISTINCT o2.staff_id), 'fm999,999,999,999')
        from orders o2
                 left join order_totals ot2
                           On o2.order_id = ot2.order_id) as avg_cnt
     , to_char(sum(ot.sub_total), 'fm999,999,999,999')    as sum_sub_total
     , (select to_char(sum(ot2.sub_total) / count(DISTINCT o2.staff_id), 'fm999,999,999,999')
        from orders o2
                 left join order_totals ot2
                           On o2.order_id = ot2.order_id) as avg_sub_total
from orders o
         right join order_totals ot on o.order_id = ot.order_idCREATE DATABASE
         right join staffs s on o.staff_id = s.id
group by s.name, o.staff_id
order by sum_sub_total
;


explain
select distinct o.staff_id
              , s.name
--     , o.order_id
--     , count(ot.order_id) as count
              , (select count(distinct o2.staff_id) from orders o2)                            as staff_cnt
              , to_char(count(o.order_id) over (partition by 0), 'fm999,999,999,999')          as count_orders
              , to_char(count(o.order_id) over (
    partition by 0) /
                        (select count(distinct o2.staff_id) from orders o2)
    , 'fm999,999,999,999')                                                                     as avg_orders_cnt
              , to_char(sum(ot.sub_total) over (partition by 0), 'fm999,999,999,999')          as sum_subb_total
              , to_char(sum(ot.sub_total) over (
    partition by 0) /
                        (select count(distinct o2.staff_id) from orders o2)
    , 'fm999,999,999,999')                                                                     as avg_subb_total
              , to_char(sum(ot.sub_total) over (partition by o.staff_id), 'fm999,999,999,999') as sum_sub_total_by_stasf

from orders o
         right join staffs s on o.staff_id = s.id
         inner join order_totals ot on o.order_id = ot.order_id
order by o.staff_id
;

select  distinct
    o.staff_id
     , s.name
--     , count(ot.order_id) as count
     , (select count(distinct o2.staff_id) from orders o2)                            as staff_cnt
     , count( staff_id) over ()
     , to_char(sum(ot.sub_total) over (partition by o.staff_id), 'fm999,999,999,999') as sum_sub_total_by_stasf
from orders o
         right join staffs s on o.staff_id = s.id
         inner join order_totals ot on o.order_id = ot.order_id
group by o.staff_id, ot.sub_total, s.name
order by o.staff_id
;
