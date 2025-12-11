<?php
use Controllers\LanguageController;
use Controllers\WebController;

if (WebController::testBDDConnexion()) {
    if (isset($_GET['lang'])) {
        LanguageController::setLanguage($_GET['lang']);
    }

    // Définition de la langue
    $lg = LanguageController::getLanguage();
    $charset = LanguageController::CHARSET;
    $locale = "$lg.$charset";
    putenv("LC_ALL=$locale");
    setlocale(LC_ALL, $locale);
    bindtextdomain('messages', ROOT_PATH . 'locales');
    bind_textdomain_codeset('messages', $charset);
    textdomain('messages');
}
