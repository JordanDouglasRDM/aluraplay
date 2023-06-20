<?php

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->exec('CREATE TABLE videos (
    id INTEGER PRIMARY KEY,
    url VARCHAR(255),
    title VARCHAR(128)
);');