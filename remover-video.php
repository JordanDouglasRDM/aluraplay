<?php
$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = $_GET['id'];
$sqlQuery = 'DELETE FROM videos WHERE id = ?';
$stmt = $pdo->prepare($sqlQuery);
$stmt->bindValue(1, $id, PDO::PARAM_INT);

if ($stmt->execute() === false) {
    header('Location:./index.php?sucesso=0' );
}else {
    header('Location:./index.php?sucesso=1' );
}
