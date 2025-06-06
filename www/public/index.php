<?php

// Indiquer les classes à utiliser
use Controllers\LanguageController;
use Slim\Factory\AppFactory;

// Activer le chargement automatique des classes
require __DIR__ . '/../vendor/autoload.php';

// Créer l'application
$app = AppFactory::create();

// Ajouter certains traitements d'erreurs
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

// Définir les routes
require __DIR__ . '/../src/routes/web.php';
require __DIR__ . '/../src/routes/api.php';

// Lancer l'application
$app->run();
