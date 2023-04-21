--0226
-- todo
with master as (
    select to_char(date_time,'MM') as month
    , to_char(date_time,'YYYY') as year
    , sum(revenue) as sum_rev
    from sales
    group by month, year
)
select year, Max(max_rev) - Max(min_rev) as hani
from (
    select year
        , percentile_cont(0) within group ( order by sum_rev ) over (PARTITION BY year) as min_rev
        , percentile_cont(1) within group ( order by sum_rev ) over (PARTITION BY year) as max_rev
    from master
     ) tbl
group by year
order by year
;

--027
select *  from (
    select product_category, product_name, cost
    ,rank() over (partition by product_category order by cost desc) as cost_rank
    from products) tbl
where cost_rank <= 3
;

--028
with master as (
   select to_char(date_time,'YYYY/MM') as year_month
    , product_id
    , sum(revenue) as sum_rev
   from sales
   group by year_month, product_id
)
select year_month, product_id, monthly_revinue_share
from (
    select year_month, product_id
    , sum_rev / sum(sum_rev) over (partition by year_month
        rows between unbounded preceding and unbounded following) as monthly_revinue_share
    from master
     ) tbl
where monthly_revinue_share > 0.4
order by monthly_revinue_share
;

--029
select first_purchase_product
,count(Distinct user_id) as number_of_user
from(
    select user_id
        ,min(first_product) as first_purchase_product
    from (
        select user_id ,product_id
        ,FIRST_VALUE(product_id) over (partition by user_id order by date_time, product_id) as first_product
        from sales
         ) tbl2
    group by user_id
    ) tbl
group by first_purchase_product
order by number_of_user desc
;

--030
with master as (
    select cid ,session_count
    ,first_value(page) over (partition by cid, session_count order by date_time) as l_page
    ,last_value(page) over (partition by cid, session_count order by date_time rows between unbounded preceding and unbounded following) as e_page
    from web_log
)
select
    concat(l_page, '->', e_page) as landing_and_exit
    , count(*) as session
from (
    select
        cid, session_count, max(l_page) as l_page
        ,max(e_page) as e_page
    from master
    group by cid, session_count
    having count(*) > 1
    order by 1,2
     ) tbbl
group by l_page, e_page
order by 2 desc
