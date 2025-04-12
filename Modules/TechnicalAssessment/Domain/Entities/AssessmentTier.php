<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Courses\Domain\Entities\Course;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class AssessmentTier extends Model
{
    use HasFactory;

    protected $fillable = ['evaluation', 'from', 'to', 'assessment_id', 'desc'];


    /**
     * assessment relationship
     * @return BelongsTo
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }

    /**
     * courses relationship
     * @return BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'tiers_courses', 'tier_id', 'course_id')
            ->withTimestamps();
    }

}
