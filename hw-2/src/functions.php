<?php


function task1($arg, $return = false)
{
    $connected = implode($arg);

    if ($return == true) {
        return $connected ;
    } elseif ($return == false) {
        foreach($arg as $ar) {
            echo "<p> $ar </p></br>";
        }
    }
}

function task2($string, ...$numbers)
{
    switch ($string) {
        case '+' :
            return array_sum($numbers);
        case '-' :
            return array_shift($numbers) - array_sum($numbers);
        case '*' :
            $mult = 1;
            foreach ($numbers as $number) {
                $mult = $number * $number;
            }
            return $mult;
        case '/' :
            $div = array_shift($numbers);
            foreach ($numbers as $number) {
                if ($number == 0) {
                    return 'Can not divide on 0';
                }
                $div = $div / $number;
            }
            return $div;
        default:
            return 'Unknown action';
    }
}

function task3($num1, $num2)
{
    if(is_int($num1) && is_int($num2)) {
        echo '<table border="2"  width="500" bgcolor="#ffe4c4">';
        for ($r = 1; $r <= $num1; $r++) {
            echo '<tr>';
            for($c = 1; $c <= $num2; $c++){
                $result = $r * $c;
                echo '<td>';
                echo $result;
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        return 'Numbers need to be integer';
    }
}

function task4()
{
    date_default_timezone_set('America/New_York');
    echo date('d.m.Y H:m');
    echo '</br>';
    echo strtotime('24.02.2016 00:00:00');
    echo '</br>';
}

function task5()
{
    $str1 = 'Карл у Клары украл Кораллы';
    $str2 = 'Две бутылки лимонада';

    echo str_replace('К', '', $str1);
    echo '</br>';
    echo str_replace('Две', 'Три', $str2);
    echo '</br>';
}

function task6($name)
{
    file_put_contents('test.txt', 'Hello again!');

    $file = fopen($name, 'r');
    if(!$file) {
        return 'There is no file';
    }

    $text = '';
    while(!feof($file)) {
        $text .= fgets($file, 1024);
    }

    echo $text;
}