<?php
$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location:./index.php?sucesso=0' );
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location:./index.php?sucesso=0');
    exit();
}

$sql = 'INSERT INTO videos (url, title) VALUES (?,?)';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(1, $url);
$stmt->bindValue(2, $titulo);

if ($stmt->execute() === false) {
    header('Location:./index.php?sucesso=0' );
}else {
    header('Location:./index.php?sucesso=1' );
}