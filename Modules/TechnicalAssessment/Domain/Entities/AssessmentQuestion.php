<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['ques', 'assessment_id', 'question_type'];


    /**
     * assessment relationship
     * @return BelongsTo
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }

    /**
     * answers relationship
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class, 'question_id', 'id');
    }


}
