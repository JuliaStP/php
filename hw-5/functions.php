<?php

function isUserSignedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function getUserByUsername(string $username): array
{
    $query = "SELECT * FROM `users` WHERE `username` = '$username' LIMIT 1";
    $ret = getDbConnection()->query($query);
    $users = $ret->fetchAll();
    return $users[0] ?? [];
}

function modifyPasswordToHash(string $password): string
{
    return sha1($password . 'fkjdnkjngomdfnjodf');
}

