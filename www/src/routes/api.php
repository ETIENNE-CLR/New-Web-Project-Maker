<?php

use Controllers\ApiController;

//-----------------------------------------------------
// Routes de l'API
//-----------------------------------------------------

// Home
$app->get('/api[/]', [ApiController::class, ApiController::API_FUNCTION]);

// Routes
$app->get('/api/{' . ApiController::SPECIFIC_TABLE_ARGUMENT_NAME . '}', [ApiController::class, ApiController::API_FUNCTION]);
$app->post('/api/{' . ApiController::SPECIFIC_TABLE_ARGUMENT_NAME . '}', [ApiController::class, ApiController::API_FUNCTION]);
