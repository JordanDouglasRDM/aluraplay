<?php

use DI\ContainerBuilder;
use League\Plates\Engine;

$builder = new ContainerBuilder();
/** @var \Psr\Container\ContainerInterface $container */
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $host = 'localhost';
        $dbname = 'db-aluraplay';
        $username = 'root';
        $password = '';
        return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    },
    Engine::class => function () {
    $templatePath = __DIR__ . '/../views';
    return new Engine($templatePath);
    }
]);
$container = $builder->build();

return $container;