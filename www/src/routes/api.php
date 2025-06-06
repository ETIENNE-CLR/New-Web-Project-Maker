<?php

use Controllers\ApiController;

$app->group('/api', function () use ($app) {
    // Route pour toutes les méthodes HTTP sur /api/{object}
    $app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{object}', [ApiController::class, 'api']);
});
