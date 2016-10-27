<?php

namespace Web\Component;

class Luggage
{
    protected $id;
    protected $name;
    protected $userName;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->userName = $data['userName'];
    }

    public function getId():string
    {
        return $this->id;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getUserName():string
    {
        return $this->userName;
    }
}