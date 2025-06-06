<?php

use Interfaces\ICRUD;
use Models\PDOSingleton;

abstract class ActiveRecord implements ICRUD
{
    protected static string $table;

    public static function findAll(): array
    {
        $pdo = PDOSingleton::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM " . static::$table);
        return array_map(fn($data) => static::fromArray($data), $stmt->fetchAll());
    }
}
