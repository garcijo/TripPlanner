<?php

namespace Web\Domain;

use Slim\PDO\Database;
use Web\Component\User;

class UserMapper
{
    private $db;

    private $usersTable = 'users';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Accept a username and look it up in the database to verify if it exists.
     *
     * @param string $userEmail The current user's username
     *
     * @return User
     */
    public function searchUser(string $userName) : User
    {
        $sql = "SELECT * FROM {$this->usersTable} WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $userName]);

        if ($rs = $stmt->fetch()) {
            return new User($rs);
        } else {
            return new User(['username' => '', 'password' => '', 'name' => '']);
        }
    }

    /**
     * Accept a username, name, and password
     * and create a new user with the given fields.
     *
     * @param string $userName The new user's username
     * @param string $pass The new user's password
     * @param string $name The new user's name
     */
    public function createUser(string $userName, string $pass, string $name)
    {
        $sql = "INSERT INTO {$this->usersTable}
            (username, password, name) VALUES
            (:username, :password, :name)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'username' => $userName,
            'password' => $pass,
            'name' => $name,
        ]);
        if (!$result) {
            throw new \Exception('Could not register user!');
        } else {
            return $userName;
        }
    }

    /**
     * Read a username and password and verify that it's a valid user.
     *
     * @param string $userName The current user's username
     * @param string $userPass  The current user's password
     *
     * @return
     */
    public function loginUser(string $username, string $pass)
    {
        $sql = "SELECT username, password, name
            FROM {$this->usersTable} WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        if ($rs = $stmt->fetch()) {
            if (password_verify($pass, $rs['password'])) {
                return new User($rs);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
