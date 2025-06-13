<?php

use Interfaces\ICRUD;
use Models\PDOSingleton;

abstract class ActiveRecord implements ICRUD
{
    protected static string $table;

    public static function findAll(): array
    {
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->query("SELECT * FROM " . static::$table);
        return array_map(fn($data) => static::fromArray($data), $stmt->fetchAll());
    }

    protected static function fromArray(array $data): static
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }
}
