<?php
session_start();

require_once 'functions.php';

function getDbConnection(): PDO
{
    static $DB;
    if(!$DB) {
        try {
            $DB = new PDO('mysql:host=127.0.0.1;dbname=hw-5', 'root', '10CasaMarina!'); //глобальная переменная по всему скрипту
        } catch (Exception $e) {
            die('error: ' . $e->getMessage());
        }
    }
    return $DB;
}