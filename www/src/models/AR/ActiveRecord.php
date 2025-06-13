<?php

namespace ActiveRecord;

use Interfaces\ICRUD;
use Models\PDOSingleton;

/**
 * Classe abstraite ActiveRecord
 *
 * Fournit des méthodes de base pour manipuler les enregistrements en base de données
 * selon le modèle Active Record (CRUD). Elle doit être étendue par chaque modèle métier.
 *
 * @package Models
 */
abstract class ActiveRecord implements ICRUD
{
    /**
     * Nom de la table associée au modèle
     * Doit être défini dans la classe enfant.
     *
     * @var string
     */
    protected static string $table;

    /**
     * Identifiant unique de l'enregistrement
     *
     * @var int
     */
    public int $id;

    /**
     * Récupère un enregistrement en base par son identifiant
     *
     * @param int $id Identifiant du record à récupérer
     * @return static|null Instance du modèle avec les données ou null si non trouvé
     */
    public static function read(int $id): ?static
    {
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return self::fromArray($stmt->fetch());
    }

    /**
     * Récupère tous les enregistrements de la table
     *
     * @return static[] Tableau d'instances du modèle contenant tous les enregistrements
     */
    public static function readAll(): array
    {
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->query("SELECT * FROM " . self::$table);
        return array_map(fn($data) => static::fromArray($data), $stmt->fetchAll());
    }

    /**
     * Enregistre ou met à jour l'enregistrement courant en base de données
     *
     * - Si la propriété `id` n’est pas définie, un nouvel enregistrement est inséré.
     * - Sinon, l’enregistrement existant est mis à jour.
     *
     * @return bool True si l’opération a réussi, False sinon
     */
    public function save(): bool
    {
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
     * Supprime l'enregistrement courant de la base de données
     *
     * @return bool True si la suppression a réussi, False sinon
     */
    public function delete(): bool
    {
        if (!isset($this->id)) return false;
        $pdo = PDOSingleton::getInstance();
        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Crée une instance du modèle à partir d’un tableau associatif (données SQL)
     *
     * @param array $data Données à injecter dans le modèle
     * @return static Instance du modèle remplie avec les données
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
