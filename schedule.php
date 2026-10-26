<?php
declare(strict_types=1);

$year = (int) ($argv[1] ?? date('Y'));
$month = (int) ($argv[2] ?? date('m'));
$count = (int) ($argv[3] ?? 1);

if ($month < 1 || $month > 12) {
    echo 'Ошибка: месяц должен быть от 1 до 12' . PHP_EOL;
    exit(1);
}

$counter = 0;
for ($i = 0; $i < $count; $i++) {
    $counter = generateSchedule($year, $month, $counter);
    
    $month++;
    if ($month > 12) {
        $month = 1;
        $year++;
    }
}

function generateSchedule(int $year, int $month, int $startCounter = 0): int {
    $dayNames = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];    
    $daysInMonth = (int) date('t', strtotime("$year-$month-01"));
    $monthNames = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    echo PHP_EOL . '=== ' . $monthNames[$month] . ' ' . $year . ' ===' . PHP_EOL;

    $workCounter = $startCounter;
    
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $dayOfWeek = (int) date('N', strtotime("$year-$month-$day"));
        
        if ($dayOfWeek === 1 && $day > 1) {
            echo PHP_EOL;
        }
        
        if ($workCounter === 0 && $dayOfWeek < 6) {
            echo "\033[32m+" . $dayNames[$dayOfWeek - 1] . ' ' . $day . "\033[0m ";
            $workCounter = 1;
        } elseif ($workCounter === 0 && $dayOfWeek >= 6) {
            echo ' ' . $dayNames[$dayOfWeek - 1] . ' ' . $day . ' ';
        } else {
            echo ' ' . $dayNames[$dayOfWeek - 1] . ' ' . $day . ' ';
            $workCounter = ($workCounter + 1) % 3;
        }
    }

    return $workCounter;
}
