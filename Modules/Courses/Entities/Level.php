<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\LevelFactory::new();
    }

    /**
     * courses relationship
     * @return HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'level_id', 'id');
    }
}
