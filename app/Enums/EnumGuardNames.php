<?php

namespace App\Enums;

// https://www.php.net/enumerations
enum EnumGuardNames : string
{

    case Admin = 'sanctum';
    case Manager = 'manager';
    case user = 'user';

}
