<?php

use Controllers\SiteController;

// Pages de base
$app->get('/', [SiteController::class, 'home']);
