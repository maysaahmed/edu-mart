<?php

namespace Modules\Users\Domain\Entities;

use App\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class EndUser extends User
{
    protected $table = 'users';

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

}
