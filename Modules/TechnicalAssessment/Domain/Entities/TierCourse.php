<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Domain\Entities\Course;


class TierCourse extends Pivot
{
    use HasFactory;
    protected $table = 'tiers_courses';
    protected $fillable = ['tier_id', 'course_id'];

    /**
     * course relationship
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * tier relationship
     * @return BelongsTo
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(AssessmentTier::class, 'tier_id', 'id');
    }

}
