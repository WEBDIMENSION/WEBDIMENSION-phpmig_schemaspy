create table customers (
    user_id integer,
    name varchar(255),
    birthday date,
    gender integer,
    prefecture varchar(255),
    register_date date,
    is_premium boolean
);


create table products (
    product_id integer,
    product_name varchar(255),
    product_category varchar(255),
    cost integer
);

create table sales (
    order_id integer,
    user_id integer,
    product_id integer,
    date_time date,
    quantity integer,
    revenue integer,
    is_proper boolean
);


create table web_log(
    cid varchar(255),
    user_id integer,
    device varchar(255),
    session_count integer,
    media varchar(255),
    date_time date,
    page varchar(255)
);
