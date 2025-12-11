<?php

use Controllers\ApiController;

//-----------------------------------------------------
// Routes de l'API
//-----------------------------------------------------

// Route home
$homeRoute = '/';
$app->group($homeRoute, function () use ($app, $homeRoute) {
    $app->map(['GET', 'POST', 'PUT', 'DELETE'], $homeRoute, [ApiController::class, ApiController::API_FUNCTION]);
});

// Les routes
$route = '/{' . ApiController::SPECIFIC_TABLE_ARGUMENT_NAME . '}';
$app->group($route, function () use ($app, $route) {
    $app->map(['GET', 'POST', 'PUT', 'DELETE'], $route, [ApiController::class, ApiController::API_FUNCTION]);
});
