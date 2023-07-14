<?php

declare(strict_types=1);

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$email = $argv[1];
$password = $argv[2];//parametro do terminal
$hash = password_hash($password, PASSWORD_ARGON2ID);

$sql = 'INSERT INTO users (email, password) VALUES (?,?);';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $email);
$stmt->bindValue(2, $hash);
$stmt->execute();