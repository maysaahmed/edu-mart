<?php

namespace Modules\Administration\Entities;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminEntity extends Admin
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'admins';

    protected static function newFactory()
    {
        return \Modules\Administration\Database\factories\AdminEntityFactory::new();
    }
}
