<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false && $url !== null) {
    header('Location:./?sucesso=0' );
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false && $titulo !== null) {
    header('Location:./?sucesso=0');
    exit();
}
$repository = new VideoRepository($pdo);

if ($repository->add(new Video($url, $titulo)) === false) {
    header('Location:./?sucesso=0' );
}else {
    header('Location:./?sucesso=1' );
}