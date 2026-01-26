<?php

/**
 * Méthode qui permet de dire si on est en mode developpeur ou non
 * @return bool si on est en mode developpeur ou non
 */
function isDevMode(): bool
{
    return isset($_ENV['DEV_MOD']) && 'true' === $_ENV['DEV_MOD'];
}

/**
 * Méthode qui aide au débuggage
 * 
 * Utilise `die()` à la fin
 */
function Debug()
{
    if (!isDevMode()) return;
    dump('Je suis passé par là');
    die();
}
