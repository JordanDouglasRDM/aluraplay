<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$titulo = filter_input(INPUT_POST, 'titulo');
if (!($id || $url || $titulo) && $id === null) {
    header('Location:./?sucesso=0' );
    exit();
}

$video = new Video($url, $titulo);
$video->setId($id);

$repository = new VideoRepository($pdo);
if ($repository->update($video)) {
    header('Location:./?sucesso=1' );
} else {
    header('Location:./?sucesso=0' );
}