<?php

//1

$name = 'Julia';
$age = '31';

echo ("My name is $name<br>");
echo ("I am $age years old<br>");
echo '" ' . '! ' . '| ' . '/ ' . "' " . '" ' . "\<br>";

//2

const PICTURES = 80;
const FELT_TIP = 23;
const PENCILS = 40;

const PAINT = PICTURES - FELT_TIP - PENCILS;
echo PICTURES . ' total pictures ' . ' - ' . FELT_TIP . ' felt-tip pens pictures ' . ' - ' . PENCILS . ' pencils pictures = ' . PAINT . ' pictures by paint<br> ';


//3

$age = 31;

if ($age >=1 && $age <=17) {
    echo 'Вам ещё рано работать<br>';
} elseif ($age >=18 && $age <=65 ) {
    echo 'Вам еще работать и работать<br>';
} elseif ($age > 65) {
    echo 'Вам пора на пенсию<br>';
} else {
    echo 'Неизвестный возраст<br>';
}

//4

$day = 7;

switch($day) {
    case $day >= 1 && $day <= 5 :
        echo 'Это рабочий день<br>';
        break;
    case $day == 6 && $day == 7 :
        echo 'Это выходной день<br>';
        break;
    case $day > 7 :
        echo 'Неизвестный день<br>';
        break;
}

//5

$CARS = [
    'bmw' => [
        'model' => 'X5',
        'speed' => 120,
        'doors' => 5,
        'year' => '2015'
    ],
    'toyota' => [
        'model' => 'yaris',
        'speed' => 130,
        'doors' => 3,
        'year' => '2010'
    ],
    'opel' => [
        'model' => 'blabla',
        'speed' => 90,
        'doors' => 5,
        'year' => '2018'
    ]
];
foreach ($CARS as $CAR => $name) {
    echo 'CAR ' . $CAR . '<br>';
    foreach ($name as $desc) {
        echo $desc . '<br>';
    }
}

//6

$rows = 10;
$cols = 10;

echo '<table border="2"  width="500" bgcolor="#ffe4c4">';

for ($r = 1; $r <= $rows; $r++) {
    echo '<tr>';
    for($c = 1; $c <= $cols; $c++){
        $result = $r * $c;
        echo '<td>';

        if ($r % 2 == 0 && $c % 2 == 0) {
            echo "($result)";
        } elseif ($r % 2 !== 0 && $c % 2 !== 0) {
            echo "[$result]";
        } else {
            echo $result;
        }
        echo '</td>';
    }
    echo '</tr>';
}
echo '</table>';
