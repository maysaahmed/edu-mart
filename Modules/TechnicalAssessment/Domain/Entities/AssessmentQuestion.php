<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


}
