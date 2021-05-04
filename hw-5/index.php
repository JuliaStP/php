<?php

require_once 'init.php';

if (!isUserSignedIn()) {
    header('Location: signinForm.php');
    die;
}

echo 'You have been logged in';
