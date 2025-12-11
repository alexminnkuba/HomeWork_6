<?php

$connection = [
    'host' => 'MySQL-8.2',
    'username' => 'root',
    'pass' => '',
    'charset' => 'utf8',
    'dbname' => 'PV315',
    'options' => [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
];

try {
    $dsn = "mysql:host={$connection['host']};dbname={$connection['dbname']};charset={$connection['charset']}";
    $conn = new PDO($dsn, $connection['username'], $connection['pass'], $connection['options']);
    echo "Connected successfuly";
} catch (PDOException $e) {
    echo "DB ERROR: {$e->getMessage()}";
}
