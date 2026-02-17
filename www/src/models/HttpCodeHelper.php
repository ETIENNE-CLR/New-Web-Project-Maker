<?php

namespace Models;

/**
 * Cette classe représente les différents codes HTTP possibles.
 */
class HttpCodeHelper
{
    /**
     * Réponse réussie (tout s'est bien passé)
     */
    public const int OK = 200;

    /**
     * Une ressource a été créée (par ex. après POST)
     */
    public const int CREATED = 201;

    /**
     * Réponse réussie mais pas de contenu à renvoyer
     */
    public const int NO_CONTENT = 204;

    /**
     * Indique une redirection temporaire.
     * Il signale au navigateur d'accéder à une autre URL via une méthode GET
     */
    public const int SEE_OTHER = 303;

    /**
     * Requête mal formée ou paramètres invalides
     */
    public const int BAD_REQUEST = 400;

    /**
     * L'utilisateur n'est pas authentifié
     */
    public const int UNAUTHORIZED = 401;

    /**
     * L'utilisateur n'a pas les droits pour accéder à la ressource
     */
    public const int FORBIDDEN = 403;

    /**
     * Ressource introuvable
     */
    public const int NOT_FOUND = 404;

    /**
     * Conflit dans la requête (ex. doublon dans la base)
     */
    public const int CONFLICT = 409;

    /**
     * Données valides mais non acceptables (erreur de validation)
     */
    public const int UNPROCESSABLE_ENTITY = 422;

    /**
     * Erreur serveur générale (bug ou exception)
     */
    public const int INTERNAL_SERVER_ERROR = 500;
}
