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
function debug()
{
    if (!isDevMode()) return;
    dump('Je suis passé par là');
    die();
}

/**
 * Méthode qui permet de mettre en majuscule
 * la première lettre d'un string
 * @param string $str le string à transformer
 * @return string Le string transformé
 */
function upperFirstChar(string $str): string
{
    return strtoupper($str[0]) . strtolower(substr($str, 1));
}
