<?php

namespace Modules\Courses\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\NoReturn;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'desc', 'duration', 'price', 'level_id', 'provider_id', 'category_id', 'location'];

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\CourseFactory::new();
    }

    /**
     * level relationship
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    /**
     * category relationship
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * provider relationship
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany('Modules\Organizations\Domain\Entities\Organization\Organization', 'hidden_courses', 'course_id', 'organization_id');
    }

    /**
     * @return HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'course_id', 'id');
    }

    public function courseFactors(): HasMany
    {
        return $this->hasMany(CourseFactor::class);
    }

}
