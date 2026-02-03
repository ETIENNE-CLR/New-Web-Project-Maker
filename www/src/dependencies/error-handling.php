<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Throwable;

if (isDevMode()) {
    // --- MODE DÉVELOPPEMENT : WHOOPS ---
    $whoops = new Run();
    $whoops->pushHandler(new PrettyPageHandler());

    // Configurer Slim pour laisser Whoops gérer l'affichage
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    $errorMiddleware->setDefaultErrorHandler(function (
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) use ($app, $whoops) {

        // Whoops doit générer le HTML sans quitter le script
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);

        $content = $whoops->handleException($exception);

        $response = $app->getResponseFactory()->createResponse(500);
        $response->getBody()->write($content);

        return $response;
    });
} else {
    // --- MODE PRODUCTION : page d’erreur simple ---
    $errorMiddleware = $app->addErrorMiddleware(false, true, true);

    $errorMiddleware->setDefaultErrorHandler(function (
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) use ($app) : Response {

        // Affichage de la vue avec le layout
        $dataLayout = ['title' => '500 Error'];
        $response = $app->getResponseFactory()->createResponse(500);
        $phpView = new PhpRenderer(ROOT_PATH . 'src/views', $dataLayout);
        $phpView->setLayout('layouts/empty.php');
        return $phpView->render($response, 'static/500.php', [
            'message' => $exception->getMessage()
        ]);
    });
}
