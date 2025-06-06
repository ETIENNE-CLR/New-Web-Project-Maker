<?php

namespace Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SiteController
{
    public static function getAddonPath(): string
    {
        $addonPath = '';
        $slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
        for ($i = $slashCount; $i > 1; $i--) {
            $addonPath .= '../';
        }
        return $addonPath;
    }

    public function home(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Title'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("layouts/base.php");
        return $phpView->render($response, 'home.php');
    }}
