<?php

namespace App\Enums;

// https://www.php.net/enumerations
enum PermissionEnum : int
{
    case create_organization  = 1;
    case edit_organization    = 2;
    case delete_organization    = 3;
    case block_organization    = 4;


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
