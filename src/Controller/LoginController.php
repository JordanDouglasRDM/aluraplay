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
            if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
                $stmt = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $stmt->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
                $stmt->bindValue(2, $userData['id']);
                $stmt->execute();
            }
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}