<?php

use Dotenv\Dotenv;

// DEPENDENCES 'phpdotenv' : Charger les variables d'environnement depuis .env
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();
