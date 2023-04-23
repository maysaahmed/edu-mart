<?php

namespace App\Enums;

// https://www.php.net/enumerations
enum EnumUserTypes : int
{

    case Admin      = 1;
    case Manager    = 2;
    case User       = 3;


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forSelect(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}
