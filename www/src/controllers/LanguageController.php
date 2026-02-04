<?php

namespace Controllers;

use Exception;
use Models\PDOSingleton;
use PDO;

/**
 * Contrôleur de gestion des langues du site.
 *
 * Cette classe permet de :
 * - Définir et récupérer la langue active de la session
 * - Charger les langues disponibles depuis la base de données
 * - Obtenir les traductions des noms de langue
 */
class LanguageController
{
    /**
     * Langue par défaut utilisée si aucune langue n'est définie dans la session
     */
    public const DEFAULT_LANGUAGE = 'fr';

    /**
     * Clé de session utilisée pour stocker la langue active
     */
    private const SESSION_KEY = 'language';

    /**
     * Charset utilisé pour les réponses HTTP liées à la langue
     */
    public const CHARSET = 'UTF-8';

    /**
     * Fonction qui permet de récupérer la langue active
     * @param bool $getKey Option qui permet de retourner la langue active de différente manière :
     * - false (par défaut) : retourne le nom du package de la langue installée sur le serveur (exemple `fr_FR`, `en_US`)
     * - true : retourne la clé de la langue (exemple `fr`, `en`)
     * @return string La langue active du site sous le format demandé
     */
    public static function getLanguage(bool $getKey = false): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::setLanguage(self::DEFAULT_LANGUAGE);
        }

        return ($getKey) ?
            $_SESSION[self::SESSION_KEY] :
            self::LANGUAGES()[$_SESSION[self::SESSION_KEY]];
    }

    /**
     * Fonction qui permet de définir la langue
     * @param string $langId La langue à définir (exemple : `fr`, `en`)
     */
    public static function setLanguage(string $langId): void
    {
        if (!array_key_exists($langId, self::LANGUAGES())) {
            throw new Exception("Invalid language ID: $langId");
        }
        $_SESSION[self::SESSION_KEY] = $langId;
    }

    /**
     * Charge toutes les langues depuis la base de données une seule fois et les met en cache.
     * 
     * @return array Tableau contenant tous les enregistrements de la table `Langue`
     * - Exemple de retour :
     * ```php  
     * [
     *  ['lang' => 'fr', 'locale' => 'fr_FR', 'nom' => 'Français'],
     *  ['lang' => 'en', 'locale' => 'en_US', 'nom' => 'English']
     * ]
     * ```
     * @throws Exception Si la requête échoue ou que la connexion à la base est rompue
     */
    private static function loadLanguages(): array
    {
        static $cache = null;
        if ($cache !== null) return $cache;

        $db = PDOSingleton::getInstance();
        $stmt = $db->query("SELECT * FROM Langue");
        $cache = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cache;
    }

    /**
     * Retourne la liste des langues disponibles sous la forme `clé => locale`
     * 
     * @return array Tableau associatif des langues, ex : `['fr' => 'fr_FR', 'en' => 'en_US']`
     */
    private static function LANGUAGES(): array
    {
        $output = [];
        foreach (self::loadLanguages() as $row) {
            $output[$row['lang']] = $row['locale'];
        }
        return $output;
    }

    /**
     * Retourne la liste des langues disponibles sous la forme `clé => nom affiché`
     * 
     * @return array Tableau associatif des langues, ex : `['fr' => 'Français', 'en' => 'English']`
     */
    public static function LANGUAGES_TEXT(): array
    {
        $output = [];
        foreach (self::loadLanguages() as $row) {
            $output[$row['lang']] = $row['nom'];
        }
        return $output;
    }

    /**
     * Fonction qui dit si la clé de la langue entré en paramètre est celle qui est active
     * @param string $key Clé à vérifier
     * @return bool Si la clé passée en paramètre correspond à la langue actuelle
     */
    public static function isThisKeyCurrentLanguage(string $key): bool
    {
        return self::LANGUAGES()[$key] === self::getLanguage();
    }
}