<?php

// mysql or postgres Default is MySQL
// faker
const FAKER_LOCATE = 'ja_JP';
const STAFF_ROLES_ARRAY = ['administrator', 'general', 'external_staff'];

// staff roles
const TABLE_STAFF_ROLES = 'staff_roles';

// staffs
const TABLE_STAFFS = 'staffs';
const STAFFS_ROWS_COUNT = '10';


//  user_rans
const TABLE_USER_RANKS = 'user_ranks';
const USERS_RANKS_ARRAY = ['premium', 'gold', 'silver', 'bronze', 'basic'];
const USERS_BIRTHDAY_FROM = '-80 years';
const USERS_BIRTHDAY_TO = '-18 years';
const USERS_CREATED_FROM = '-5 years';
const USERS_CREATED_TO = '-1 years';

// users
const TABLE_USERS = 'users';
const USERS_DATA_ROWS_COUNT = 10000;
const USERS_DELETED_ROWS_COUNT = 200;

// login_history
const TABLE_LOGIN_HISTORIES = 'login_histories';
const LOGIN_HISTORY_DATA_ROWS_COUNT = 100000;

// products
const TABLE_PRODUCTS = 'products';
const PRODUCTS_DATA_ROWS_COUNT = 3000;
const PRODUCTS_DELETED_ROWS_COUNT = 100;
const PRODUCTS_PRICE_MIN = 1000;
const PRODUCTS_PRICE_MAX = 30000;
const PRODUCTS_STOCK_MIN = 0;
const PRODUCTS_STOCK_MAX = 100;

// orders
const TABLE_ORDERS = 'orders';
const ORDERS_DATA_ROWS_COUNT = 30000;

// orders detail
const TABLE_ORDER_DETAILS = 'order_details';
const ORDER_DETAILS_PRODUCT_ROWS_MIN_COUNT = 1;
const ORDER_DETAILS_PRODUCT_ROWS_MAX_COUNT = 10;

const ORDER_DETAILS_QUANTITY_MIN_COUNT = 1;
const ORDER_DETAILS_QUANTITY_MAX_COUNT = 10;

// orders total
const TABLE_ORDER_TOTALS = 'order_totals';

// product reviews
const TABLE_PRODUCT_REVIEWS = 'product_reviews';
const PRODUCTS_REVIEW_ROWS_COUNT = 5000;

// delivery
const TABLE_DELIVERIES = 'deliveries';
const ORDERS_DELIVERIES = [
    ['name' => 'ヤマト運輸', 'cost' => 600],
    ['name' => '佐川急便', 'cost' => 500],
    ['name' => 'ゆうパック', 'cost' => 400]
];

// payment
const TABLE_PAYMENTS = 'payments';
const ORDERS_PAYMENTS = [
    ['name' => 'クレジットカード', 'cost' => 0],
    ['name' => 'コンビニ', 'cost' => 300],
    ['name' => '銀行振込', 'cost' => 100]
];

// product_brands
const TABLE_BRANDS = 'product_brands';
const ORDERS_BRANDS = [
    ['name' => 'Brand001'],
    ['name' => 'Brand002'],
    ['name' => 'Brand003'],
    ['name' => 'Brand004'],
    ['name' => 'Brand005'],
    ['name' => 'Brand006'],
    ['name' => 'Brand007'],
    ['name' => 'Brand008'],
    ['name' => 'Brand009'],
    ['name' => 'Brand010'],
];
// product_categories
const TABLE_CATEGORIES = 'product_categories';
const ORDERS_CATEGORIES = [
    ['name' => 'category001'],
    ['name' => 'category002'],
    ['name' => 'category003'],
    ['name' => 'category004'],
    ['name' => 'category005'],
    ['name' => 'category006'],
    ['name' => 'category007'],
    ['name' => 'category008'],
    ['name' => 'category009'],
    ['name' => 'category010'],
];
