<?php

namespace Controllers;

use Models\AppInfo;
use Models\HttpCodeHelper;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Services\AuthService;

class UserController
{
    public function logout(Request $request, Response $response): Response
    {
        // Déconnexion
        setcookie($_ENV['JWT_KEY'], '', 0, '/');
        return $response
            ->withHeader('Location', '/login')
            ->withStatus(HttpCodeHelper::SEE_OTHER);
    }

    public function account(Request $request, Response $response): Response
    {
        // Affichage de la vue avec le layout
        $dataLayout = ['title' => AppInfo::NAME . " | Mon compte"];
        $phpView = new PhpRenderer(ROOT_PATH . 'src/views', $dataLayout);
        $phpView->setLayout('layouts/normal.php');
        return $phpView->render($response, 'account.php', [
            // 'user' => AuthService::getUser($response)
        ]);
    }
}
