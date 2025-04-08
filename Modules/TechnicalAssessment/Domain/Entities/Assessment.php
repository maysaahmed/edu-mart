<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'assessment_type', 'desc', 'mcq_points', 't/f_points', 'sb_points'];


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
}
