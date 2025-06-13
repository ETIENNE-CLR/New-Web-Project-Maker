<?php

namespace Models;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Classe PDOSingleton
 *
 * Gère une connexion unique à la base de données à l'aide du pattern Singleton.
 * Cette classe empêche l’instanciation multiple, le clonage et la désérialisation.
 * Les paramètres de connexion sont chargés à partir des variables d’environnement ($_ENV).
 *
 * @package Models
 */
class PDOSingleton
{
    /**
     * Instance unique de la connexion PDO
     * @var PDO|null
     */
    private static ?PDO $instance = null;

    /**
     * Constructeur privé pour empêcher l'instanciation externe
     */
    private function __construct() {}

    /**
     * Empêche le clonage de l'instance singleton
     * @return void
     */
    private function __clone(): void {}

    /**
     * Empêche la désérialisation de l'instance singleton
     * @return void
     */
    private function __wakeup(): void {}

    /**
     * Retourne l'instance unique de PDO. La crée si elle n'existe pas encore.
     * @return PDO L'instance unique de la connexion à la base de données
     * @throws RuntimeException Si la connexion à la base de données échoue
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=%s',
                    $_ENV['DB_HOST'],
                    $_ENV['DB_NAME'],
                    $_ENV['DB_CHARSET']
                );
                self::$instance = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                throw new RuntimeException('Erreur de connexion à la base de données.');
            }
        }

        return self::$instance;
    }
}
