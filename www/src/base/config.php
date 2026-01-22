<?php
// Config
date_default_timezone_set('Europe/Paris');
require ROOT_PATH . 'src/base/env.php';

// Dev mode
function isDevMode(): bool
{
    return isset($_ENV['DEV_MOD']) && 'true' === $_ENV['DEV_MOD'];
}

// Affichage des erreurs
if (isDevMode()) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// Debug
function Debug()
{
    if (!isDevMode()) return;
    dump('Je suis passé par là');
    die();
}
