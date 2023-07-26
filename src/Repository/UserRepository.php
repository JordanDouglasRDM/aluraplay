<?php

namespace Alura\Mvc\Repository;

class UserRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function passwordVerify(string $email, string $password): bool
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        $result = password_verify($password, $userData['password'] ?? '');
        if ($result) {
            if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
                $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
                $statement->bindValue(2, $userData['id']);
                $statement->execute();
            }
        }
        return $result;
    }

}