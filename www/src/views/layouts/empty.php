<?php

use Controllers\WebController;
use Controllers\LanguageController;

// $lang = (WebController::testBDDConnexion()) ? LanguageController::getLanguage(true) : 'fr';
$lang = 'fr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'load/link.php' ?>
    <title><?= $title ?></title>
</head>

<body>
    <?= $content ?>    
    <?php require_once 'load/script.php' ?>
</body>

</html>