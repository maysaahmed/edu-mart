<?php

namespace Modules\Administration\Domain\Entities\Admin;

use App\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'users';

    protected static function newFactory()
    {
        return \Modules\Administration\Database\factories\AdminEntityFactory::new();
    }
}
