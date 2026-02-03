<?php

// Renforce le typage strict / fiabilité du code
declare(strict_types=1);

use Dotenv\Dotenv;

// Charger les variables d'environnement depuis .env
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Config
date_default_timezone_set('Europe/Paris');
require ROOT_PATH . 'src/base/funct.php';

// Affichage des erreurs
if (isDevMode()) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
