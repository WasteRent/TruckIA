<?php

namespace App\Classes;

class Helpers
{
    public static function shortReference(string $reference)
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $reference));
    }
}
