<?php

namespace Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $guarded = [];
    protected $table = 'password_reset_tokens';

}
