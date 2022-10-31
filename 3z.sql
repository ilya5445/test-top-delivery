SELECT
    dr.`title` as "Регион",
    DATE_FORMAT(p.`date_create`, "%Y-%m") as "Период (YYYY-MM)",
    COUNT(CASE WHEN p.`work_status_id` = 3 THEN 1 ELSE NULL END) as "Количество доставленных",
	COUNT(CASE WHEN p.`work_status_id` = 5 THEN 1 ELSE NULL END) as "Количество отказов"
FROM
    `parcels` p
JOIN `dir_regions` dr ON dr.`id` = p.`region_delivery_id`
WHERE
    p.`work_status_id` = 3 OR p.`work_status_id` = 5
GROUP BY
    p.`region_delivery_id`,
    DATE_FORMAT(p.`date_create`, "%Y-%m")
ORDER BY 
    DATE_FORMAT(p.`date_create`, "%Y-%m")