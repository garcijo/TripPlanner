<?php

namespace Web\Component;

class User
{
    protected $email;
    protected $name;
    protected $password;

    /**
     * Accept an array of data matching properties of this class
     * and create the class.
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data)
    {
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->name = $data['name'];
    }

    public function getUsername():string
    {
        return $this->username;
    }

    public function getPass():string
    {
        return $this->password;
    }

    public function getName():string
    {
        return $this->name;
    }
}