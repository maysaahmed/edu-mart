<?php

namespace Modules\Courses\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Assessment\Domain\Entities\Factor;


class CourseFactor extends Model
{
    use HasFactory;
    protected $table = 'courses_factors';
    protected $fillable = ['course_id', 'factor_id', 'result'];


    /**
     * questions relationship
     * @return BelongsTo
     */
    public function factor(): BelongsTo
    {
        return $this->BelongsTo(Factor::class, 'factor_id', 'id');
    }

    /**
     * user relationship
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'user_id', 'id');
    }


}
