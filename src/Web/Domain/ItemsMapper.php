<?php

namespace Web\Domain;

use Slim\PDO\Database;
use Web\Component\Item;

class ItemsMapper
{
    private $db;

    private $itemsTable = 'items';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function searchItem( $itemName, $userName)
    {
        $sql = "SELECT * FROM {$this->itemsTable} WHERE name = :itemname AND username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['itemname' => $itemName, 'username' => $userName]);

        if ($rs = $stmt->fetch()) {
            return new Item($rs);
        } else {
            return null;
        }
    }

    public function createItem
    (
        $itemName,
        $description = null,
        $userName,
        $toBuy = 0,
        $price = null
    ) {
        $sql = "INSERT INTO {$this->itemsTable}
            (name, description, to_buy, price, username) VALUES
            (:name, :description, :to_buy, :price, :username)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'name' => $itemName,
            'description' => $description,
            'to_buy' => $toBuy,
            'price' => $price,
            'username' => $userName,
        ]);
        if (!$result) {
            throw new \Exception('Could not create item!');
        } else {
            return $itemName;
        }
    }

    public function getAllItems(string $userName):array
    {
        $sql = 'SELECT * FROM items WHERE username=:username';
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(['username' => $userName]);
        $items = [];
        if ($result) {
            while ($item = $stmt->fetch()) {
                $items[] = $item;
            }
        }

        return $items;
    }

}
