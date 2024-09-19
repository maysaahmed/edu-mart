<?php

namespace Modules\Assessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Factor extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'desc', 'low_desc', 'moderate_desc', 'high_desc', 'formula'];
    public $translatable = ['name', 'desc', 'low_desc', 'moderate_desc', 'high_desc',];

    /**
     * questions relationship
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'factor_id', 'id');
    }


}
