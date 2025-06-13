<?php

namespace Interfaces;

/**
 * Interface ICRUD
 *
 * Définit un contrat de base pour les opérations CRUD (Create, Read, Update, Delete)
 * à implémenter dans les modèles utilisant le pattern Active Record.
 */
interface ICRUD
{
    /**
     * Récupère un enregistrement par son identifiant
     *
     * @param int $id Identifiant de l'enregistrement
     * @return static|null Instance du modèle ou null si non trouvé
     */
    public static function read(int $id): ?static;

    /**
     * Récupère tous les enregistrements de la table associée
     *
     * @return static[] Liste d'instances du modèle
     */
    public static function readAll(): array;

    /**
     * Sauvegarde l'enregistrement courant (insert ou update)
     *
     * @return bool True si la sauvegarde a réussi, False sinon
     */
    public function save(): bool;

    /**
     * Supprime l'enregistrement courant
     *
     * @return bool True si la suppression a réussi, False sinon
     */
    public function delete(): bool;
}
