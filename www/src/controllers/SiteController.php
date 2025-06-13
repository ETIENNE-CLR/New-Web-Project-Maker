<?php

namespace Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Contrôleur principal du site.
 * 
 * Gère l'affichage des pages web et fournit des outils utilitaires pour adapter les chemins relatifs selon la profondeur d'URL.
 */
class SiteController
{
    /**
     * Génère dynamiquement un chemin relatif (`../`) permettant de revenir jusqu'au dossier `public/`.
     * 
     * Ce chemin est utile pour les liens relatifs dans les vues, afin qu'ils restent valides quelle que soit la profondeur de l'URL.
     * 
     * Par exemple, si l'URL est `/admin/utilisateur/add`, cette méthode retournera `'../../'`.
     * 
     * @return string Une chaîne contenant des `../` pour revenir à la racine publique.
     */
    public static function getAddonPath(): string
    {
        $addonPath = '';
        $slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
        for ($i = $slashCount; $i > 1; $i--) {
            $addonPath .= '../';
        }
        return $addonPath;
    }

    /**
     * Affiche la page d'accueil du site (`home.php`) avec le layout de base.
     * 
     * Utilise le moteur de rendu PhpRenderer de Slim pour afficher la vue avec un layout commun.
     * 
     * @param Request $request L'objet de requête HTTP (inutilisé ici mais nécessaire pour l'interface)
     * @param Response $response L'objet de réponse HTTP
     * @return Response La réponse contenant le rendu HTML de la page
     */
    public function home(Request $request, Response $response): Response
    {
        // Définir les variables disponibles dans la vue
        $dataLayout = ['title' => 'Title'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("layouts/base.php");
        return $phpView->render($response, 'home.php');
    }
}
