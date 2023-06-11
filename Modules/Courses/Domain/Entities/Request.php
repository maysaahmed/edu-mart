<?php

namespace Modules\Courses\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['course_id', 'user_id', 'status'];
    protected $table = 'course_requests';

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\RequestFactory::new();
    }

    /**
     * user relationship
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Entities\User\User::class, 'user_id', 'id');
    }

    /**
     * course relationship
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id')->withTrashed();
    }


}
