<?php

// Config
date_default_timezone_set('Europe/Paris');
require ROOT_PATH . 'src/base/env.php';
require ROOT_PATH . 'src/base/funct.php';

// Affichage des erreurs
if (isDevMode()) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
