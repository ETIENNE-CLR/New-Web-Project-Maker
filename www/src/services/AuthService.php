<?php

namespace Services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\HttpCodeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;
use stdClass;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

/**
 * Classe logger qui permet de gérer les connexions utilisateurs
 */
class AuthService
{
    /**
     * Constante qui définit quelle algorithme de cryptage
     * il faut utiliser pour le JWT
     */
    public const CRYPT_ALGO = 'HS256';

    /**
     * Fonction pour récupérer le JWT depuis l'en-tête Authorization ou le cookie
     *
     * @param Response $response La réponse HTTP à retourner
     * @param bool $testMode option qui empêche la génération des erreurs (par défaut sur `false`)
     * @return stdClass|false le token ou false
     */
    public static function getToken(Response $response, bool $testMode = false): stdClass|false
    {
        // Tentative depuis cookie
        $jwt = $_COOKIE['JWT'] ?? null;

        if (!$jwt) {
            if ($testMode) return false;
            $response->withStatus(HttpCodeHelper::UNAUTHORIZED);
            throw new Exception('JWT manquant ou invalide');
        }

        try {
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], self::CRYPT_ALGO));
            $data = $decoded->data ?? null;

            if (!isset($data)) {
                $response->withStatus(HttpCodeHelper::FORBIDDEN);
                return false;
            }

            return $decoded;
        } catch (Exception $e) {
            $response->withStatus(HttpCodeHelper::UNAUTHORIZED);
            return false;
        }
    }

    /**
     * Récupérer l'ID de l'utilisateur connécté depuis le token
     * @param Response $response La réponse HTTP à retourner
     * @return int|null L'id INT de l'utilisateur. Null s'il n'a pas été récupéré
     */
    public static function getUserId(Response $response): int|null
    {
        $token = self::getToken($response);
        return ($token !== false)
            ? $token->data->id // A revérifier !
            : null;
    }

    // /**
    //  * Méthode pour récupérer l'objet l'utilisateur
    //  * @param Response $response La réponse HTTP à retourner
    //  * @return User|null une instance User s'il a été récupérer. Null s'il n'a pas été récupéré
    //  */
    // public static function getEmploye(Response $response): User|null
    // {
    //     $id = self::getEmployeId($response);
    //     return ($id !== null) ? User::read($id) : null;
    // }

    /**
     * Fonction qui va permettre de se logger à un compte utilisateur
     * @param Response $response La réponse HTTP à retourner
     * @param string $username Nom de l'utilsateur qu'on doit connecter
     * @param string $password Mot de passe de l'utilsateur qu'on doit connecter
     * @param bool $rememberMe Option qui sert à dire s'il faut garder la connexion
     * @return array tableau qui comprendra tous les messages de retour
     */
    public function login(Response $response, string $email, string $password, bool $rememberMe): array
    {
        $messages = [];
        $messages['success'] = true;
        $messages['details'] = [];

        // Règles de validation
        $emailValidator = Validator::email()->notEmpty();
        $passwordValidator = Validator::stringType()->length(8, null);
        $factory = new PasswordHasherFactory(['default' => ['algorithm' => 'auto']]);
        $passwordHasher = $factory->getPasswordHasher('default');

        // Validations
        if (!$emailValidator->validate($email)) {
            $messages['success'] = false;
            $messages['details'][] = "Email invalide";
        }
        if (!$passwordValidator->validate($password)) {
            $messages['success'] = false;
            $messages['details'][] = "Mot de passe trop court (min 8 caractères)";
        }
        if (!$messages['success']) {
            $response->withStatus(HttpCodeHelper::BAD_REQUEST);
            return $messages;
        }

        // Récupérer l'utilisateur
        // $allUsers = User::readAll();
        $allUsers = [];
        $user = array_find($allUsers, function ($u) use ($email) {
            return $u->email === $email;
        });
        if (!isset($user)) {
            $response->withStatus(HttpCodeHelper::NOT_FOUND);
            $messages['success'] = false;
            $messages['details'][] = "L'utilisateur n'existe pas !";
            return $messages;
        }

        // Verifier le mot de passe
        if (!$passwordHasher->verify($user->motDePasse, $password)) {
            $response->withStatus(HttpCodeHelper::UNPROCESSABLE_ENTITY);
            $messages['success'] = false;
            $messages['details'][] = "Le mot de passe est invalide !";
            return $messages;
        }

        // Authentification réussie - Génération du JWT
        $jwtPayload = [
            'id' => $user->id,
            'email' => $user->email
        ];

        $expiresInDays = $rememberMe ? 31 : 1;
        $messages["jwt"] = self::generateNewJWT($jwtPayload, $expiresInDays);

        $messages['nbDays'] = $expiresInDays;
        $messages["estLivreur"] = $user->estLivreur;

        return $messages;
    }

    /**
     * Fonction qui va permettre de s'enregistrer un compte utilisateur
     * @param Response $response La réponse HTTP à retourner
     * @param string $username Nom de l'utilsateur qu'on doit connecter
     * @param string $password Mot de passe de l'utilsateur qu'on doit connecter
     * @param bool $rememberMe Option qui sert à dire s'il faut garder la connexion
     * @return array tableau qui comprendra tous les messages de retour
     */
    public function register(Response $response, string $username, string $password, bool $rememberMe): array
    {
        $messages = [];
        $messages['success'] = true;
        $messages['details'] = [];

        // Règles de validation
        $factory = new PasswordHasherFactory(['default' => ['algorithm' => 'auto']]);
        $passwordHasher = $factory->getPasswordHasher('default');

        // Récupérer l'utilisateur
        // $allUsers = User::readAll();
        $allUsers = [];
        $user = array_find($allUsers, function ($u) use ($username) {
            return $u->username === $username;
        });
        if (isset($user)) {
            $response->withStatus(HttpCodeHelper::FORBIDDEN);
            $messages['success'] = false;
            $messages['errorMessage'][] = "L'utilisateur existe déjà !";
            return $messages;
        }

        // Création et sauvegarde du nouvel utilisateur
        // $newUser = new User();
        $newUser = new stdClass();
        $newUser->username = $username;
        $newUser->password = $passwordHasher->hash($password);
        // $newUser->save();
        $response->withStatus(HttpCodeHelper::OK);

        // Authentification réussie - Génération du JWT
        $jwtPayload = [
            'id' => $newUser->id
        ];

        $expiresInDays = $rememberMe ? 31 : 1;
        $messages["jwt"] = self::generateNewJWT($jwtPayload, $expiresInDays);
        $messages['nbDays'] = $expiresInDays;

        return $messages;
    }

    /**
     * Fonction qui va générer un Json Web Token
     * @param array $data les données qu'on veut sauvegarder
     * @param int $nbDays le nombre de jours que le jwt sera valide
     * @return string le token généré
     */
    public static function generateNewJWT(array $data = [], int $nbDays = 31): string
    {
        // Init
        $issuedAt = time();
        $expirationTime = $issuedAt + (86400 * $nbDays);
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        ];

        // Setter
        $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], self::CRYPT_ALGO);
        setcookie('JWT', $jwt, [
            'expires' => time() + 86400 * $nbDays,
            'path' => '/',
            'httponly' => true,
            'secure' => true,
            'samesite' => 'Strict'
        ]);
        return $jwt;
    }
}
