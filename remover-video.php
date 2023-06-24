<?php
$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id !== false && $id !== null)
$sqlQuery = 'DELETE FROM videos WHERE id = ?';
$stmt = $pdo->prepare($sqlQuery);
$stmt->bindValue(1, $id, PDO::PARAM_INT);

if ($stmt->execute() === false) {
    header('Location:./?sucesso=0' );
}else {
    header('Location:./?sucesso=1' );
}
