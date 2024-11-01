<?php

namespace Modules\Users\Domain\Entities;

use App\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Assessment\Domain\Entities\Result;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class EndUser extends User
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'type',
        'check_email_status',
        'email_verified_at',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    /**
     * Organization relationship
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
    /**
     * Organization relationship
     * @return BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'created_by', 'id');
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserAccount::class, 'user_id', 'id');
    }

    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Result::class, 'user_id', 'id');
    }

}
