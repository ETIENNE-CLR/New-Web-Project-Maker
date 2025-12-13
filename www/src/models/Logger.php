<?php

namespace Models;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\HttpCodeHelper;
use stdClass;

/**
 * Classe logger qui permet de gérer les connexions utilisateurs
 */
class Logger
{
    /**
     * Constante qui définit quelle algorithme de cryptage
     * il faut utiliser pour le JWT
     */
    private const CRYPT_ALGO = 'HS256';

    /**
     * Constante qui définit la clé de session pour l'id de l'utilisateur connecté
     */
    public const SESSION_USER_KEY = 'idUserConnected';

    /**
     * Méthode qui permet de récupérer le JWR
     * Emis par l'application
     * @return stdClass|false Le tableau associatif sous forme de classe s'il est valide. False s'il ne l'est pas
     */
    public static function getToken(): stdClass|false
    {
        return self::checkJWT(getallheaders(), true);
    }

    /**
     * Récupérer l'ID de l'utilisateur connécté depuis le token
     * @return int|null L'id INT de l'utilisateur. Null s'il n'a pas été récupéré
     */
    public static function getUserId(): int|null
    {
        $token = self::getToken();
        $idSession = $_SESSION[self::SESSION_USER_KEY] ?? null;
        return ($token !== false)
            ? ($token->data->userId)
            : (isset($idSession) ? $idSession : null);
    }

    /**
     * Méthode pour récupérer l'objet l'utilisateur
     * @return User|null une instance User s'il a été récupérer. Null s'il n'a pas été récupéré
     */
    // public static function getUser(): User|null
    // {
    //     $id = self::getUserId();
    //     return ($id !== null) ? User::read($id) : null;
    // }

    /**
     * Fonction qui va permettre de se logger à un compte utilisateur
     * @param string $username Nom de l'utilsateur qu'on doit connecter
     * @param string $password Mot de passe de l'utilsateur qu'on doit connecter
     * @param bool $rememberMe Option qui sert à dire s'il faut garder la connexion
     * @return array tableau qui comprendra tous les messages de retour
     */
    public function login(string $username, string $password, bool $rememberMe): array
    {
        $messages = [];

        // Récupérer l'utilisateur
        // $allUsers = User::readAll();
        $allUsers = [];
        $user = array_find($allUsers, function ($u) use ($username) {
            return $u->username === $username;
        });
        if (!isset($user)) {
            http_response_code(HttpCodeHelper::NOT_FOUND);
            $messages['success'] = false;
            $messages['details'][] = "L'utilisateur n'existe pas !";
            return $messages;
        }

        // Verifier le mot de passe
        if (!password_verify($password, $user->password)) {
            http_response_code(HttpCodeHelper::UNPROCESSABLE_ENTITY);
            $messages['success'] = false;
            $messages['details'][] = "Le mot de passe ne correspond pas !";
            return $messages;
        }

        // Authentification réussie
        http_response_code(HttpCodeHelper::OK);
        $messages['success'] = true;

        // rememberMe
        if ($rememberMe) {
            $messages["jwt"] = self::generateNewJWT([
                'userId' => $user->id,
                'username' => $user->username,
            ]);
        } else {
            $_SESSION[self::SESSION_USER_KEY] = $user->id;
        }
        return $messages;
    }

    /**
     * Fonction qui va permettre de s'enregistrer un compte utilisateur
     * @param string $username Nom de l'utilsateur qu'on doit connecter
     * @param string $password Mot de passe de l'utilsateur qu'on doit connecter
     * @param bool $rememberMe Option qui sert à dire s'il faut garder la connexion
     * @return array tableau qui comprendra tous les messages de retour
     */
    public function register(string $username, string $password, bool $rememberMe): array
    {
        $messages = [];

        // Récupérer l'utilisateur
        // $allUsers = User::readAll();
        $allUsers = [];
        $user = array_find($allUsers, function ($u) use ($username) {
            return $u->username === $username;
        });
        if (isset($user)) {
            http_response_code(HttpCodeHelper::FORBIDDEN);
            $messages['success'] = false;
            $messages['errorMessage'][] = "L'utilisateur existe déjà !";
            return $messages;
        }

        // Création et sauvegarde du nouvel utilisateur
        // $newUser = new User();
        $newUser = new stdClass();
        $newUser->username = $username;
        $newUser->password = password_hash($password, PASSWORD_DEFAULT);
        // $newUser->save();
        http_response_code(HttpCodeHelper::OK);
        $messages[] = [
            "success" => "true",
        ];

        // rememberMe
        if ($rememberMe) {
            $messages["jwt"] = self::generateNewJWT([
                'userId' => $newUser->id,
                'username' => $newUser->username,
            ]);
        } else {
            $_SESSION[self::SESSION_USER_KEY] = $newUser->id;
        }
        return $messages;
    }

    /**
     * Fonction qui va générer un Json Web Token qui comprendra l'id de l'utilisateur connecté
     * @return array les données qu'on veut sauvegarder
     * @return string le JWT crypté
     */
    public static function generateNewJWT(array $data = [], int $nbDays = 61): string
    {
        // Init
        $issuedAt = time();
        $expirationTime = ($issuedAt + 3600) * 24 * $nbDays;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        ];

        // Générer le JWT
        return JWT::encode($payload, $_ENV['JWT_SECRET'], self::CRYPT_ALGO);
    }

    /**
     * Fonction qui va vérifier un Json Web Token
     * @param array $headers en-tête de la requête API
     * @param bool $testMode option qui empêche la génération des erreurs (par défaut sur `false`)
     */
    public static function checkJWT(array $headers, bool $testMode = false): false|stdClass
    {
        // Valider le JWT
        $authHeader = $headers['Authorization'] ?? '';
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            if (!$testMode) {
                http_response_code(HttpCodeHelper::UNPROCESSABLE_ENTITY);
                throw new Exception('Authorization header manquant ou invalide', 1);
                die();
            } else {
                return false;
            }
        }

        // Decoder le JWT
        $jwt = $matches[1];
        try {
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], self::CRYPT_ALGO));
            $userId = $decoded->data->userId ?? null;

            if (!$userId) {
                http_response_code(HttpCodeHelper::FORBIDDEN);
                exit;
            }
            return $decoded;
        } catch (Exception $e) {
            http_response_code(HttpCodeHelper::UNAUTHORIZED);
            return false;
        }
    }
}
