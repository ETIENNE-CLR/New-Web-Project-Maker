<?php

namespace Interfaces;

interface ICRUD
{
    public function create();
    static function readAll();
    static function read(int $id);
    public function update();
    static function delete(int $id);
}
