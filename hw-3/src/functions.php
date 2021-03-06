<?php

function task1()
{
    $USERS = 50;
    $NAMES = ['Julia', 'Maria', 'Pam', 'David', 'Mike'];
    $data = [];

    for($i = 0; $i < $USERS; $i++) {
        array_push($data,
        [
            'id' => $i,
            'name' => $NAMES[array_rand($NAMES)],
            'age' => rand(18, 45)
        ]
    );
}
    $json = json_encode($data);
    file_put_contents('users.json', $json);

    $content = file_get_contents('users.json');

    if ($content === false) {
        error_log('There was an error getting data');
        return;
    } else {
        $file = json_decode($content);
        echo 'Data is successfully saved <br>';

        $nameCount = array_column($file, 'name');;
        $nameCount = array_count_values($nameCount);

        echo 'Name count: <br>';
        foreach ($nameCount as $name => $value) {
              echo $value . ' '  . $name . "s <br>";
        }

        $age = array_column($data, 'age');
        $averageAge = array_sum($age) / count($age);
        echo "Average age is: $averageAge";

    }
}