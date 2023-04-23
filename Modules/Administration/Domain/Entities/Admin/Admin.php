<?php

namespace Modules\Administration\Domain\Entities\Admin;

use App\Domain\Entities\User\User;

class Admin extends User
{
    protected $table = 'users';

//    protected $guard_name = ['admin-api'];
//
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

}
