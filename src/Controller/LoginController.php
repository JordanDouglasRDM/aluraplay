<?php

namespace Alura\Mvc\Controller;

class LoginController implements Controller
{
    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'db-aluraplay';
        $username = 'root';
        $password = '';

        $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$email);
        $stmt->execute();

        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        $correctPassword = password_verify($password, $userData['password'] ?? '');

        if ($correctPassword) {
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}