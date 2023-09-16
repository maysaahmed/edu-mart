<?php

namespace Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'accounts';
    protected $fillable = ['user_id', 'job_title', 'area', 'date_of_birth', 'gender'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('EndUser', 'user_id');
    }
}
