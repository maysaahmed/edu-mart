<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'assessment_type', 'desc'];


    /**
     * questions relationship
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class, 'assessment_id', 'id');
    }

    /**
     * tiers relationship
     * @return HasMany
     */
    public function tiers(): HasMany
    {
        return $this->hasMany(AssessmentTier::class, 'assessment_id', 'id');
    }

    /**
     * organizations relationship
     * @return BelongsToMany
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_assessment')
            ->withPivot(['limit_users'])
            ->withTimestamps();
    }

    /**
     * results relationship
     * @return HasMany
     */
    public function results(): HasMany
    {
        return $this->hasMany(UserAssessmentResult::class);
    }
}
