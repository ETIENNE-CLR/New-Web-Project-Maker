<?php

use Slim\Factory\AppFactory;

define('ROOT_PATH', __DIR__ . '/../');
require ROOT_PATH . 'vendor/autoload.php';

// Créer l'application Slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Initialisation middlewares et autres configurations
require ROOT_PATH . 'src/middlewares/env.php';
require ROOT_PATH . 'src/middlewares/error-handling.php';
// require ROOT_PATH . 'src/middlewares/multi-language.php';

// Création de la session
session_start();

// Définir les routes
require ROOT_PATH . 'src/routes/web.php';
require ROOT_PATH . 'src/routes/api.php';

// Lancer l'application
$app->run();
