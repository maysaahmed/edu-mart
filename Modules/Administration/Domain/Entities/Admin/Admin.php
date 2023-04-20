<?php

namespace Modules\Administration\Domain\Entities\Admin;

use App\Domain\Entities\User\User;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Admin extends User
{
    protected $table = 'users';
    protected $guard = 'admin-api';
//    protected $guard_name = ['admin-api'];
//
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

}
