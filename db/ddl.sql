create table dir_regions
(
    id int auto_increment primary key,
    title varchar(160) charset utf8 not null
)
    collate = utf8_bin;

create table dir_webshops
(
    id int auto_increment primary key,
    title varchar(160) charset utf8 not null
)
    comment 'Клиенты' collate = utf8_bin;

create table dir_partners
(
    id int auto_increment primary key,
    title varchar(160) charset utf8 not null
)
    comment 'Партнеры' collate = utf8_bin;

drop table parcels;
create table parcels
(
    id int auto_increment primary key,
    parcel_id int not null comment 'Номер заказа',
    region_delivery_id int null comment 'Регион',
    work_status_id int null comment 'Статус выполнения',
    status_id int null comment 'Статус движения',
    webshop_id int null comment 'Клиент',
    partner_id int null comment 'Партнер',
    date_create date null comment 'Дата создания заказа'
)
    comment 'Заказы' collate = utf8_bin;
;
drop table parcel_log;
create table parcel_log
(
    id int auto_increment primary key,
    parcel_id int null comment 'Заказ',
    date_create datetime null comment 'Дата события',
    order_log_event_type_id int null comment 'Код Типа события',
    order_log_event_type_title varchar(160) charset utf8 not null comment 'Наименование типа события',
    new_value varchar(160) charset utf8 not null comment 'Код события',
    new_value_title varchar(255) charset utf8 not null comment 'Наименование события'
)
    comment 'Собятия с заказами: статусы выполнения, движения, редактирование' collate = utf8_bin;
;

