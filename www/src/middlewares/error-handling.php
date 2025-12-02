<?php

use Psr\Http\Message\ServerRequestInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Throwable;

// DEPENDENCES 'whoops' : Gestion des erreurs en développement
$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());

// Middleware d'erreur Slim + intégration Whoops
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app, $whoops) {
    // On demande à Whoops de renvoyer le HTML au lieu d'afficher directement
    $whoops->allowQuit(false);
    $whoops->writeToOutput(false);
    $content = $whoops->handleException($exception);

    $response = $app->getResponseFactory()->createResponse(500);
    $response->getBody()->write($content);
    return $response;
});
