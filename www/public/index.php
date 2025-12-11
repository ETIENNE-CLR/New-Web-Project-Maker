<?php

use Slim\Factory\AppFactory;

// Config
date_default_timezone_set('Europe/Paris');
define('ROOT_PATH', __DIR__ . '/../'); // Prend à partir de `www/`
require ROOT_PATH . 'vendor/autoload.php';

// Créer l'application Slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Initialisation middlewares et autres configurations
require ROOT_PATH . 'src/middlewares/env.php';
require ROOT_PATH . 'src/middlewares/error-handling.php';

// Création de la session
session_start();

// Définir les routes
require ROOT_PATH . 'src/routes/web.php';
require ROOT_PATH . 'src/routes/api.php';

// Lancer l'application
$app->run();
