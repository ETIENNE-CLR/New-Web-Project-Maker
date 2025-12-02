<?php

use Controllers\WebController;

//-----------------------------------------------------
// Routes de la vue web
//-----------------------------------------------------

// Routes
$app->get('/', [WebController::class, 'home']);
