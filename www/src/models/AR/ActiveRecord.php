<?php

use Interfaces\ICRUD;
use Models\PDOSingleton;

/**
 * Classe abstraite pour les actives records
 */
abstract class ActiveRecord implements ICRUD
{
    protected static string $table;
    public int $id;

    /**
     * Fonction pour lire un record
     * @param int $id Identifiant du record
     * @return ?static Objet contenant le record
     */
    public static function read(int $id): ?static
    {
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return self::fromArray($stmt->fetch());
    }

    /**
     * Fonction pour récupérer tous les records de la table
     * @return array Tableau contenant tous les records
     */
    public static function readAll(): array
    {
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->query("SELECT * FROM " . self::$table);
        return array_map(fn($data) => static::fromArray($data), $stmt->fetchAll());
    }

    /**
     * Fonction pour sauvegarder les modifications des propriétés. Pour utiliser le `update`, il faut **définir l'id**.
     * @return bool **True** si l'enregistrement est un succès. **False** si c'est un échec
     */
    public function save(): bool
    {
        // Init
        $pdo = PDOSingleton::getInstance();
        $properties = get_object_vars($this);
        unset($properties['id']);

        if (!isset($this->id)) {
            // Create
            $columns = implode(',', array_keys($properties));
            $placeholders = implode(',', array_fill(0, count($properties), '?'));
            $stmt = $pdo->prepare("INSERT INTO " . self::$table . " ($columns) VALUES ($placeholders)");
            $success = $stmt->execute(array_values($properties));
            if ($success) $this->id = $pdo->lastInsertId();
            return $success;
        } else {
            // Update
            $columns = implode(' = ?, ', array_keys($properties)) . ' = ?';
            $stmt = $pdo->prepare("UPDATE " . self::$table . " SET $columns WHERE id = ?");
            return $stmt->execute([...array_values($properties), $this->id]);
        }
    }

    /**
     * Fonction permettant de supprimer le record
     * @return bool **True** si la suppression est un succès. **False** si c'est un échec
     */
    public function delete(): bool
    {
        if (!isset($this->id)) return false;
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Fonction permettant de transformer un tableau associatif d'un record en objet
     * @param array $data Tableau associatif à transformer
     * @return static Record transformé en objet
     */
    protected static function fromArray(array $data): static
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }
}
