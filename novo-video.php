<?php
$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


$sql = 'INSERT INTO videos (url, title) VALUES (?,?)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $_POST['url']);
$stmt->bindValue(2, $_POST['titulo']);

if ($stmt->execute() === false) {
    header('Location:./index.php?sucesso=0' );
}else {
    header('Location:./index.php?sucesso=1' );
}