<?php
$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$titulo = filter_input(INPUT_POST, 'titulo');
if (!($id || $url || $titulo)) {
    header('Location:./?sucesso=0' );
    exit();
}
$sqlQuery = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';

$stmt = $pdo->prepare($sqlQuery);
$stmt->bindValue(':url',$url);
$stmt->bindValue(':title',$titulo);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
if ($stmt->execute()) {
    header('Location:./?sucesso=1' );
} else {
    header('Location:./?sucesso=0' );
}