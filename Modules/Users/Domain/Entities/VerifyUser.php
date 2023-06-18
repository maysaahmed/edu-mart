<?php

namespace Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Domain\Entities\User\User', 'user_id');
    }
}
