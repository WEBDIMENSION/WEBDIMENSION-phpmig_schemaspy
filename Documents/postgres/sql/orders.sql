-- Sum sub_total
explain
select to_char(sum(sub_total), 'fm999,999,999,999')
from order_totals
;


-- Count orders
select to_char(count(sub_total), 'fm999,999,999,999') as order_cnt
from order_totals
;

-- AVG sub_total
select to_char(sum(sub_total) / count(id), 'fm999,999,999,999') avg_sub_total
from order_totals
;
