<?php

namespace App\Repository;

use App\Config\Database;

class AbstractRepo
{
    protected $tableName;
    protected $className;
    protected Database $db;
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function selectAll(): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName}";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll($pdo::FETCH_CLASS, $this->className);
    }

    public function selectById(int $id): ?object
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id ;");
        $stmt->execute(["id" => $id]);
        $obj =  $stmt->fetchObject($this->className);
        return $obj === false ? null : $obj;
    }

    public function insert(mixed $obj): int
    {
        $pdo = $this->db->getConnection();
        $dbArray = $obj->toDbArray();
        $keys = [];
        foreach ($dbArray as $key => $val) {
            $keys[] = $key;
        }
        $columns =  "(" . implode(', ', $keys) . ")";
        $placeholders =  "(:" . implode(', :', $keys) . ")";
        $stmt = $pdo->prepare("INSERT INTO {$this->tableName} {$columns} VALUES {$placeholders}");
        $stmt->execute($dbArray);
        return (int)$pdo->lastInsertId();
    }
}
