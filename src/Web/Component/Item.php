<?php

namespace Web\Component;

class Item
{
    protected $id;
    protected $name;
    protected $description;
    protected $toBuy;
    protected $price;
    protected $userName;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->toBuy = $data['toBuy'];
        $this->price = $data['price'];
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

    public function getDescription():string
    {
        return $this->description;
    }

    public function getToBuy():string
    {
        return $this->toBuy;
    }

    public function getPrice():string
    {
        return $this->price;
    }

    public function getUserName():string
    {
        return $this->userName;
    }
}