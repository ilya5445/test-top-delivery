/*
** Количество созданных заказов, но не принятых на складе ТопДеливери
*/
SELECT COUNT(*) AS total FROM `parcels` p WHERE p.`status_id` < 3;

/* 
** Необходимо в разрезе каждого месяца и каждого Клиента показать количество заказов у которых нет записи в логе 
** с типом события «2; Изменение статуса движения» и событием «3;Получен в ТД». 
*/

SELECT
    DATE_FORMAT(p.`date_create`, "%Y-%m") as `create_period`,
    p.`webshop_id`,
    COUNT(*) as total
FROM
    `parcels` p
WHERE
    p.`parcel_id` NOT IN(
        SELECT
            `parcel_id`
        FROM
            `parcel_log`
        WHERE
            `order_log_event_type_id` = 2 AND `new_value` = 3
        GROUP BY
            `parcel_id`
    )
GROUP BY
    DATE_FORMAT(p.`date_create`, "%Y-%m"),
    p.`webshop_id`
DESC;