<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiController
{
    public function api(Request $request, Response $response, array $args): Response
    {
        // Init
        $returnData = [
            "message" => "Bienvenue sur l'API !",
            "details" => "Veuillez passer en paramètre ce que vous voulez recevoir."
        ];

        // En-têtes CORS
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type');

        // Récupérer la méthode HTTP
        $method = $request->getMethod();
        switch ($method) {
            case 'GET':
                // Logique GET
                break;

            case 'POST':
                // Logique POST
                break;

            case 'PUT':
                // Logique PUT
                break;

            case 'DELETE':
                // Logique DELETE
                break;

            default:
                $returnData = [
                    "warning" => "Méthode de la requête invalide",
                    "details" => "Vérifier que la méthode soit GET, POST, PUT, DELETE"
                ];
                break;
        }

        // Répondre avec les données au format JSON
        $response->getBody()->write(json_encode($returnData));
        return $response;
    }
}
