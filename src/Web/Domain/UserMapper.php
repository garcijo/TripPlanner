<?php

namespace Web\Domain;

use PDO;
use Web\Domain\Component\User;

class UserMapper
{
    private $pdo;
    private $db;

    private $usersTable = 'users';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Accept a username and look it up in the database to verify if it exists.
     *
     * @param string $userEmail The current user's username
     *
     * @return User
     */
    public function searchUser(string $email) : User
    {
        $sql = "SELECT * FROM {$this->usersTable} WHERE email = :$email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        if ($rs = $stmt->fetch()) {

            return new User($rs);
        } else {

            return new User(['email' => '', 'name' => '', 'password' => '']);
        }
    }

    /**
     * Accept a username, name, and password
     * and create a new user with the given fields.
     *
     * @param string $userName  The new user's name
     * @param string $userEmail The new user's username
     * @param string $userPass  The new user's password
     */
    public function createUser(string $name, string $email, string $pass)
    {
        $sql = "INSERT INTO {$this->usersTable}
            (name, email, password) VALUES
            (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $pass,
        ]);
        if (!$result) {
            throw new \Exception('Could not register user!');
        }
    }

    /**
     * Read a username and password and verify that it's a valid user.
     *
     * @param string $userEmail The current user's username
     * @param string $userPass  The current user's password
     *
     * @return User
     */
    public function loginUser(string $email, string $pass) : User
    {
        $sql = "SELECT name, email, password
            FROM {$this->usersTable} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        if ($rs = $stmt->fetch()) {
            if (password_verify($pass, $rs['password'])) {
                return new User($rs);
            } else {
                return new User(['email' => '', 'name' => '', 'password' => '']);
            }
        } else {
            return new User(['email' => '', 'name' => '', 'password' => '']);
        }
    }
}
