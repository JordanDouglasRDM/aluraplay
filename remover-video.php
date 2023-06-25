<?php

use Alura\Mvc\Repository\VideoRepository;

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id !== false && $id !== null){
    header('Location:./?sucesso=0' );
}
$repository = new VideoRepository($pdo);

if ($repository->remove($id)) {
    header('Location:./?sucesso=1' );
}else {
    header('Location:./?sucesso=0' );
}
