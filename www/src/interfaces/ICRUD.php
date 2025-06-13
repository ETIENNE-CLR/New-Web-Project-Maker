<?php

namespace Interfaces;

/**
 * Interface pour les records CRUD
 */
interface ICRUD
{
    public static function read(int $id): ?static;
    public static function readAll(): array;
    public function save(): bool;
    public function delete(): bool;
}
