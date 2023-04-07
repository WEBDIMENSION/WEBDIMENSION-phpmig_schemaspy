select * from users
;


explain
select 1 from staffs s
    where not exists(
        select *
            from staff_roles sr
            where s.id = sr.id
    )
;

select * from staff_roles
;