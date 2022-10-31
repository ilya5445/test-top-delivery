<?php

// Получение данных из файла (можно сдлеать и подключение с БД)
$rawData = array_map(fn($file) => str_getcsv($file, ';'), file('../db/testPeriodIntake.csv'));
array_walk($rawData, function(&$a) use ($rawData) {
    $a = array_combine($rawData[0], $a);
});
array_shift($rawData);

// Результат
$result = [];

/**
 * Дней между датами
 *
 * @param string $date1
 * @param string $date2
 * @return void
 */
function dayDiffDate(string $date1, string $date2) {
    $datediff = strtotime($date1) - strtotime($date2);
    $days = round($datediff / (60 * 60 * 24));
    return $days;
}

// Форматируем данные
$countRawData = count($rawData);
for ($i = 0; $i < $countRawData; $i++) { 

    $_item = $rawData[$i];
    $groupId = $_item['groupId'];
    $periodBegin = $_item['periodBegin'];
    $periodEnd = $_item['periodEnd'];

    if (!isset($result[$groupId][$periodBegin])) {
        $result[$groupId][$periodBegin] = [
            'groupId' => $groupId,
            'minPeriodBegin' => $periodBegin,
            'maxPeriodEnd' => $periodEnd,
            'sumIntakeItg' => $_item['sumIntake'],
            'days' => dayDiffDate($periodEnd, $periodBegin)
        ];
    }

    for ($j = $i+1; $j < $countRawData-1; $j++) { 
        $_item2 = $rawData[$j];

        if ($groupId != $_item2['groupId']) continue;

        if (isset($result[$groupId][$periodBegin])) {
            if (strtotime($result[$groupId][$periodBegin]['maxPeriodEnd']) >= strtotime($_item2['periodBegin'])) {
                $result[$groupId][$periodBegin]['maxPeriodEnd'] = $_item2['periodEnd'];
                $result[$groupId][$periodBegin]['sumIntakeItg'] += $_item2['sumIntake'];
                $result[$groupId][$periodBegin]['days'] = dayDiffDate($result[$groupId][$periodBegin]['maxPeriodEnd'], $result[$groupId][$periodBegin]['minPeriodBegin']);
            }
        }
    }
}

// Сбрасываем ключи
// $result = array_map(fn($_i) => array_values($_i), $result);
$result = array_map(function($_i) {
    usort($_i, function($a, $b) {
        if ($a['days'] == $b['days']) return 0;
        return $a['days'] < $b['days'] ? 1 : -1;
    });
    return array_values($_i);
}, $result);

// Формирование CSV
$csvHeader = ['groupId', 'minPeriodBegin', 'maxPeriodEnd', 'sumIntakeItg'];

$out = fopen('result.csv', 'w');
fputcsv($out, $csvHeader, ';');

$maxSumIntake = [
    'value' => 0,
    'item' => []
];

foreach ($result as $value) {
    $item = $value[0];

    $csvItem = [];
    $csvItem[] = $item['groupId'];
    $csvItem[] = $item['minPeriodBegin'];
    $csvItem[] = $item['maxPeriodEnd'];
    $csvItem[] = $item['sumIntakeItg'];

    if ($maxSumIntake['value'] == 0 || $maxSumIntake['value'] <= $item['sumIntakeItg']) {
        $maxSumIntake['value'] = $item['sumIntakeItg'];
        $maxSumIntake['item'] = $csvItem;
    }

    fputcsv($out, $csvItem, ';');
}

// В самой последней строке файла вывести номер группы и период с максимальной суммой заявок
if (!empty($maxSumIntake['item'])) fputcsv($out, $maxSumIntake['item'], ';');

fclose($out);