<?php

namespace Modules\Users\Domain\Entities;

use App\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class Manager extends User
{
    protected $table = 'users';

    /**
     * Organization relationship
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'Organization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(EndUser::class, 'created_by', 'id');
    }
}
