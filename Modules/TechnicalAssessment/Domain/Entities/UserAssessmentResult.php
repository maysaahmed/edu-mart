<?php

namespace Modules\TechnicalAssessment\Domain\Entities;

use App\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAssessmentResult extends Model
{
    use HasFactory;
    protected $table = 'user_assessment_results';
    protected $fillable = ['user_id', 'assessment_id', 'score', 'started_at', 'submitted_at', 'answers'];


    /**
     * assessment relationship
     * @return BelongsTo
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }

    /**
     * assessment relationship
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
