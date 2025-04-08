<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['answer_text', 'is_correct', 'question_id'];


    /**
     * assessment relationship
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class, 'question_id', 'id');
    }


}
