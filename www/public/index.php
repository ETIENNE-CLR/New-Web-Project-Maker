<?php

use Slim\Factory\AppFactory;

// Config
define('ROOT_PATH', __DIR__ . '/../'); // Prend à partir de `www/`
require ROOT_PATH . 'vendor/autoload.php';
require ROOT_PATH . 'src/base/config.php';

// Création de la session
session_start();

// Créer l'application
$app = AppFactory::create();

// Middlewares CORE
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Initialisation des dépendances
require ROOT_PATH . 'src/dependencies/multi-language.php';

// Initialisation des middlewares
require ROOT_PATH . 'src/middlewares/error-handling.php';

// Définir les routes
require ROOT_PATH . 'src/routes/web.php';
require ROOT_PATH . 'src/routes/api.php';

// Lancer l'application
$app->run();
