<?php

namespace Middleware;

use Models\HttpCodeHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 * Middleware de gestion des rôles
 *
 * Vérifie que l'utilisateur authentifié possède le rôle requis
 * pour accéder à une route donnée.
 *
 * ⚠️ Ce middleware doit être utilisé APRÈS le AuthMiddleware
 * (qui ajoute l'utilisateur dans les attributs de la requête).
 */
class RoleMiddleware
{
    /**
     * Rôle requis pour accéder à la route
     *
     * @var string
     */
    private string $role;

    /**
     * Constructeur
     *
     * @param string $role Rôle autorisé (ex: "admin", "livreur")
     */
    public function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * Méthode exécutée lors du passage dans le middleware
     *
     * @param ServerRequestInterface  $request  Requête HTTP entrante
     * @param RequestHandlerInterface $handler  Handler suivant (route ou middleware)
     *
     * @return ResponseInterface Réponse HTTP
     */
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Récupération de l'utilisateur depuis la requête
        $user = $request->getAttribute('user');

        // Si le rôle de l'utilisateur ne correspond pas au rôle requis
        if (!$user || $user->role !== $this->role) {
            return new Response(HttpCodeHelper::FORBIDDEN);
        }

        // L'utilisateur est autorisé → passage à la suite
        return $handler->handle($request);
    }
}
