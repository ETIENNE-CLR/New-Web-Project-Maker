<?php

namespace Models;

use PDO;
use PDOException;
use RuntimeException;

class PDOSingleton
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone(): void {}
    private function __wakeup(): void {}

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
