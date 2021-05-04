<?php

require_once 'init.php';

if (isUserSignedIn()) {
    header('Location: index.php');
    die;
}

$username = $_POST['username'];
$email = $_POST['email'];
$typedPassword = $_POST['password'];
$password = modifyPasswordToHash($typedPassword);

if (getUserByUsername($username)) {
    echo 'Oops! Seems like this username is already taken.';
    die;
}

$query = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
$ret = getDbConnection()->query($query);

if ($ret) {
    echo 'You are successfully signed up!';
} else {
    echo 'There was an error';
    echo $query . '<br>';
    var_dump($_DB_CONNECTION->errorInfo());
}
