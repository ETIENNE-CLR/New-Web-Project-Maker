<?php

namespace Controllers;

use Models\HttpCodeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Services\AuthService;

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
     * Nom de la fonction pour le point d'entré de l'API.
     */
    public const string API_FUNCTION = 'api';

    /**
     * Nom de l'argument pour l'API.
     */
    public const string SPECIFIC_TABLE_ARGUMENT_NAME = 'table';

    /**
     * Instance qui gère tout ce qui est connexion
     */
    private AuthService $auth;

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
        if (!isset($this->auth)) {
            $this->auth = new AuthService();
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
     * @param Response $response La réponse HTTP à retourner
     * @return bool Si un utilisateur est connecté
     */
    public static function userIsConnected(Response $response): bool
    {
        return AuthService::getUserId($response) !== null;
    }

    /**
     * Méthode qui retourne les données
     * qui vont être retournée par l'API
     * en fonction de la méthode HTTP
     * @param string $method Méthode HTTP de la requête
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à retourner
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function httpMethodViewer(string $method, Request $request, Response $response, array $args): array
    {
        // Rien n'est spécifié
        if (!isset($args[self::SPECIFIC_TABLE_ARGUMENT_NAME])) {
            $response->withStatus(HttpCodeHelper::OK);
            return [
                "message" => "Bienvenue sur l'API !",
                "details" => "Veuillez passer en paramètre ce que vous voulez recevoir."
            ];
        }

        // Traitement de la méthode HTTP
        switch ($method) {
            case 'GET':
                return $this->get($response, $args);

            case 'POST':
                return $this->post($request, $response, $args);

            case 'PUT':
                return $this->put($request, $response, $args);

            case 'DELETE':
                return $this->delete($response, $args);

            default:
                $response->withStatus(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvaise méthode HTTP !",
                    "details" => "Veuillez utiliser une méthode HTTP valide (GET, POST, PUT, DELETE)"
                ];
        }
    }

    /**
     * Méthode pour la requête API en GET
     * @param Response $response La réponse HTTP à retourner
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function get(Response $response, array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        switch ($param) {
            case 'amIConnected':
                $amIConnected = self::userIsConnected($response);
                $response->withStatus($amIConnected ? HttpCodeHelper::OK : HttpCodeHelper::UNAUTHORIZED);
                return [
                    'yes' => $amIConnected
                ];

            default:
                $response->withStatus(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }

    /**
     * Méthode pour la requête API en POST
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à retourner
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function post(Request $request, Response $response, array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        $body = $request->getParsedBody();
        if (empty($body)) {
            $response->withStatus(HttpCodeHelper::BAD_REQUEST);
            return ["warning" => "Aucune données n'a été envoyées"];
        }

        switch ($param) {
            default:
                $response->withStatus(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }

    /**
     * Méthode pour la requête API en PUT
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à retourner
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function put(Request $request, Response $response, array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        $body = $request->getParsedBody();
        if (empty($body)) {
            $response->withStatus(HttpCodeHelper::BAD_REQUEST);
            return ["warning" => "Aucune données n'a été envoyées"];
        }

        switch ($param) {
            default:
                $response->withStatus(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }

    /**
     * Méthode pour la requête API en DELETE
     * @param Response $response La réponse HTTP à retourner
     * @param array $args arguments de la requête
     * @return array un tableau JSON avec les données
     */
    private function delete(Response $response, array $args): array
    {
        $param = $args[self::SPECIFIC_TABLE_ARGUMENT_NAME];
        switch ($param) {
            default:
                $response->withStatus(HttpCodeHelper::BAD_REQUEST);
                return [
                    "error" => "Mauvais paramètre spécifié !",
                    "details" => "Le chemin avec le paramètre joint n'est pas valide !"
                ];
        }
    }
}
