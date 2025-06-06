<?php

namespace Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class Logger
{
    private const PRIVATE_KEY = 'Super';
    private const CRYPT_ALGO = 'HS256';

    public static function login($username, $password): array
    {
        $messages = [];

        // Vérifier si l'utilisateur existe
        // $user = User::findByUsername($username);
        $user = [];
        if (!$user || !password_verify($password, $user['password'])) {
            array_push($messages, "L'utilisateur n'existe pas !");
        }

        if ($messages == []) {
            // Authentification réussie
            http_response_code(200);
            $messages = [
                "success" => "true",
                "jwt" => self::generateNewJWT($user['id'])
            ];
        }
        return $messages;
    }

    public static function register($username, $password): array
    {
        $messages = [];

        // Vérifier si l'utilisateur existe
        // $user = User::findByUsername($username);
        $user = [];
        if (is_array($user)) {
            array_push($messages, "L'utilisateur existe déjà !");
        }

        if ($messages == []) {
            // Création et sauvegarde du nouvel utilisateur
            // $newUser = new User();
            $newUser = new stdClass();
            $newUser->username = $username;
            $newUser->password = password_hash($password, PASSWORD_DEFAULT);
            // $newUser->save();
            http_response_code(200);
            $messages = [
                "success" => "true",
                "jwt" => self::generateNewJWT($newUser->id)
            ];
        }
        return $messages;
    }

    private static function generateNewJWT(int $idUser): string
    {
        // Init
        // $user = User::find($idUser);
        $user = [];
        $issuedAt = time();
        $nbDay = 7; // 1 semaine
        $expirationTime = ($issuedAt + 3600) * 24 * $nbDay;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'userId' => $user['id'],
                'username' => $user['username'],
            ]
        ];

        // Générer le JWT
        $jwt = JWT::encode($payload, self::PRIVATE_KEY, self::CRYPT_ALGO);
        return $jwt;
    }

    public static function checkJWT($headers): false|stdClass
    {

        $authHeader = $headers['Authorization'] ?? '';

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            throw new Exception('Authorization header manquant ou invalide', 1);
            exit;
        }

        $jwt = $matches[1];
        try {
            $decoded = JWT::decode($jwt, new Key(self::PRIVATE_KEY, self::CRYPT_ALGO));
            $userId = $decoded->data->userId ?? null;

            if (!$userId) {
                http_response_code(403);
                exit;
            }
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }
}
