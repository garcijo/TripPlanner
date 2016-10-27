<?php

namespace Web\Domain;

use Slim\PDO\Database;
use Web\Component\Item;

class LuggageMapper
{
    private $db;

    private $bagsTable = 'luggage';
    private $bagsItemsTable = 'bagsItems';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createBag($bagName, $userName)
    {
        $sql = "INSERT INTO {$this->bagsTable} (name, username) VALUES (:name, :username)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'name' => $bagName,
            'username' => $userName,
        ]);
        if (!$result) {
            throw new \Exception('Could not create item!');
        } else {
            return $bagName;
        }
    }

    public function getAllBags(string $userName):array
    {
        $sql = 'SELECT * FROM {$this->bagsTable} WHERE username=:username';
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(['username' => $userName]);
        $bags = [];
        if ($result) {
            while ($bag = $stmt->fetch()) {
                $bags[] = $bag;
            }
        }

        return $bags;
    }

    public function deleteBag(int $bagId)
    {
        $sql = 'DELETE FROM {$this->bagsTable} WHERE id=:id';
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(['id' => $bagId]);
        if (!$result) {
            throw new \Exception('Could not delete bag!');
        }

        return true;
    }

    public function addItemToBag($bagId, $itemId)
    {
        $sql = "INSERT INTO {$this->bagsItemsTable} (bagId, itemId) VALUES (:bagId, :itemId)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'bagId' => $bagId,
            'itemId' => $itemId,
        ]);
        if (!$result) {
            throw new \Exception('Could not create item!');
        } else {
            return $bagId;
        }
    }

    public function deleteItemFromBag(int $bagId, int $itemId)
    {
        $sql = 'DELETE FROM {$this->bagsItemsTable} WHERE bagId=:bagId AND itemId=:itemId';
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'bagId' => $bagId,
            'itemId' => $itemId,
        ]);
        if (!$result) {
            throw new \Exception('Could not delete item from bag!');
        }

        return true;
    }

}
