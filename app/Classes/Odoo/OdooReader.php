<?php

namespace App\Classes\Odoo;

use \JsonMachine\Items;

class OdooReader
{
    private $pointer;

    public function __construct(string $filepath) {
        $this->pointer = Items::fromFile($filepath, ['pointer' => '/result/Vehiculos']);
    }

    public function iterate() {
        return $this->pointer;
    }
}
