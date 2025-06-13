<?php

use Controllers\LanguageController;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

// Chargement des classes avec Composer
require __DIR__ . '/../vendor/autoload.php';

// Charger les variables d'environnement depuis .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Créer l'application Slim
$app = AppFactory::create();

// Middleware
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

// Définir les routes
require __DIR__ . '/../src/routes/web.php';
require __DIR__ . '/../src/routes/api.php';

// Lancer l'application
$app->run();
