<?php

namespace Middleware;

use Controllers\Logger;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\HttpCodeHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Services\AuthService;
use Slim\Psr7\Response;

/**
 * Middleware d'authentification
 *
 * Vérifie la présence et la validité du JWT stocké dans les cookies.
 * Si le token est valide, les informations de l'utilisateur sont
 * ajoutées à la requête (attribute "user").
 *
 * Sinon, une réponse HTTP 401 (Unauthorized) est retournée.
 */
class AuthMiddleware
{
    /**
     * Méthode appelée automatiquement par Slim lors du passage
     * dans le middleware.
     *
     * @param ServerRequestInterface  $request  Requête HTTP entrante
     * @param RequestHandlerInterface $handler  Handler suivant (route ou autre middleware)
     *
     * @return ResponseInterface Réponse HTTP
     */
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $token = $request->getCookieParams()['JWT'] ?? null;

        if (!$token) {
            return new Response(HttpCodeHelper::UNAUTHORIZED);
        }

        try {
            $decoded = JWT::decode(
                $token,
                new Key($_ENV['JWT_SECRET'], AuthService::CRYPT_ALGO)
            );
            $request = $request->withAttribute('user', $decoded->data);
        } catch (Exception $e) {
            return new Response(HttpCodeHelper::UNAUTHORIZED);
        }

        return $handler->handle($request);
    }
}
