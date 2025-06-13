<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Contrôleur de l'API principale
 * 
 * Ce contrôleur fournit un point d'entrée pour tester les appels API.
 * Il gère les méthodes HTTP classiques (GET, POST, PUT, DELETE) et 
 * renvoie une réponse JSON avec les en-têtes CORS nécessaires.
 */
class ApiController
{
    /**
     * Point d'entrée de l'API.
     * 
     * Gère la requête HTTP selon sa méthode (GET, POST, PUT, DELETE),
     * ajoute les en-têtes nécessaires (notamment pour CORS) et renvoie
     * une réponse JSON.
     * 
     * @param Request $request L'objet représentant la requête HTTP entrante
     * @param Response $response L'objet représentant la réponse HTTP à retourner
     * @param array $args Les arguments de route (généralement inutilisés ici)
     * @return Response La réponse HTTP au format JSON
     */
    public function api(Request $request, Response $response, array $args): Response
    {
        // Init
        $returnData = [];
        
        // Définir les en-têtes CORS et le type de contenu JSON
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type');

        // Détection de la méthode HTTP utilisée
        $method = $request->getMethod();
        switch ($method) {
            case 'GET':
                // Logique GET à implémenter ici
                break;

            case 'POST':
                // Logique POST à implémenter ici
                break;

            case 'PUT':
                // Logique PUT à implémenter ici
                break;

            case 'DELETE':
                // Logique DELETE à implémenter ici
                break;

            default:
                // Réponse pour méthode HTTP non prise en charge
                $returnData = [
                    "message" => "Bienvenue sur l'API !",
                    "details" => "Veuillez passer en paramètre ce que vous voulez recevoir."
                ];
                break;
        }

        // Écriture de la réponse JSON dans le corps de la réponse
        $response->getBody()->write(json_encode($returnData));
        return $response;
    }
}
