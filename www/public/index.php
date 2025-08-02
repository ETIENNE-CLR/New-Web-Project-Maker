<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Controllers\LanguageController;
use Controllers\SiteController;
use Models\PDOSingleton;

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

// Création de la session
session_start();

// Multi-langues
if (SiteController::testBDDConnexion()) {
    if (isset($_GET['lang'])) {
        LanguageController::setLanguage($_GET['lang']);
    }

    // Définition de la langue
    $lg = LanguageController::getLanguage();
    $charset = LanguageController::CHARSET;
    $locale = "$lg.$charset";
    putenv("LC_ALL=$locale");
    setlocale(LC_ALL, $locale);
    bindtextdomain('messages', __DIR__ . '/../locales');
    bind_textdomain_codeset('messages', $charset);
    textdomain('messages');
}

// Définir les routes
require __DIR__ . '/../src/routes/web.php';
require __DIR__ . '/../src/routes/api.php';

// Lancer l'application
$app->run();
