SELECT
    COUNT(*) AS isReceived,
    COUNT(pl2.`id`) AS isSuccess,
    (COUNT(pl2.`id`) * 100 / COUNT(*)) AS percent
FROM
    `parcel_log` pl
LEFT JOIN `parcel_log` pl2 ON
    pl2.`parcel_id` = pl.`parcel_id` AND pl2.`order_log_event_type_id` = 10 AND pl2.`new_value` = 3
WHERE
    pl.`order_log_event_type_id` = 2 AND pl.`new_value` = 7;


SELECT
    COUNT(*) AS isReceived,
    COUNT(pl2.`id`) AS isSuccess,
    (COUNT(pl2.`id`) * 100 / COUNT(*)) AS percent
FROM
    `parcels` p
JOIN `parcel_log` pl ON
    pl.`parcel_id` = p.`parcel_id` AND pl.`order_log_event_type_id` = 2 AND pl.`new_value` = 7
LEFT JOIN `parcel_log` pl2 ON
    pl2.`parcel_id` = pl.`parcel_id` AND pl2.`order_log_event_type_id` = 10 AND pl2.`new_value` = 3;