<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Organizations\Domain\Entities\Organization\Organization;


class OrganizationAssessment extends Pivot
{
    use HasFactory;
    protected $table = 'organization_assessment';
    protected $fillable = ['organization_id', 'assessment_id', 'limit_users', 'report'];

    /**
     * organization relationship
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

}
