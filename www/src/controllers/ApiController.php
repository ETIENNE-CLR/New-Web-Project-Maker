<?php

namespace Controllers;

use Models\HttpCodeHelper;
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
    public const string API_FUNCTION = 'api';
    public const string SPECIFIC_TABLE_ARGUMENT_NAME = 'table';
    private Logger $logger;

    /**
     * Point d'entrée de l'API.
     * 
     * Gère la requête HTTP
     * ajoute les en-têtes nécessaires (notamment pour CORS)
     * et renvoie une réponse JSON.
     * 
     * @param Request $request L'objet représentant la requête HTTP entrante
     * @param Response $response L'objet représentant la réponse HTTP à retourner
     * @param array $args Les arguments de route (généralement inutilisés ici)
     * @return Response La réponse HTTP au format JSON
     */
    public function api(Request $request, Response $response, array $args): Response
    {
        // Définir les en-têtes CORS et le type de contenu JSON
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type');

        // Détection de la méthode HTTP utilisée
        if (!isset($this->logger)) {
            $this->logger = new Logger();
        }
        $method = $request->getMethod();
        $returnData = $this->httpMethodViewer($method, $request, $response, $args);

        // Écriture de la réponse JSON dans le corps de la réponse
        $response->getBody()->write(json_encode($returnData));
        return $response;
        die;
    }

    /**
     * Méthode qui permet de dire s'il y a un utilisateur connecté
     * @return bool Si un utilisateur est connecté
     */
    public static function userIsConnected(): bool
    {
        return Logger::getUserId() !== null;
    }

    /**
     * Méthode qui retourne les données
     * qui vont être retournée par l'API
     * en fonction de la méthode HTTP
     * @param string $method Méthode HTTP de la requête
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function httpMethodViewer(string $method, Request $request, Response $response, array $args): array
    {
        // Rien n'est spécifié
        if (!isset($args[self::SPECIFIC_TABLE_ARGUMENT_NAME])) {
            http_response_code(HttpCodeHelper::OK);
            return [
                "message" => "Bienvenue sur l'API !",
                "details" => "Veuillez passer en paramètre ce que vous voulez recevoir."
            ];
        }

        // Traitement de la méthode HTTP
        switch ($method) {
            case 'GET':
                return $this->get($args);

            case 'POST':
                return $this->post($request, $args);

            case 'PUT':
                return $this->put($request, $args);

            case 'DELETE':
                return $this->delete($args);

            default:
                http_response_code(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvaise méthode HTTP !",
                    "details" => "Veuillez utiliser une méthode HTTP valide (GET, POST, PUT, DELETE)"
                ];
        }
    }

    /**
     * Méthode pour la requête API en GET
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function get(array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        switch ($param) {
            case 'amIConnected':
                $amIConnected = self::userIsConnected();
                http_response_code($amIConnected ? HttpCodeHelper::OK : HttpCodeHelper::UNAUTHORIZED);
                return [
                    'yes' => $amIConnected
                ];

            default:
                http_response_code(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }

    /**
     * Méthode pour la requête API en POST
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function post(Request $request, array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        $body = $request->getParsedBody();
        if (empty($body)) {
            http_response_code(HttpCodeHelper::BAD_REQUEST);
            return ["warning" => "Aucune données n'a été envoyées"];
        }

        switch ($param) {
            default:
                http_response_code(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }

    /**
     * Méthode pour la requête API en PUT
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function put(Request $request, array $args): array
    {
        return []; // tmp
    }

    /**
     * Méthode pour la requête API en DELETE
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function delete(array $args): array
    {
        return []; // tmp
    }
}
