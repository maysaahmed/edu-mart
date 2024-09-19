<?php

namespace Modules\Assessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['ques', 'order', 'factor_id'];
    public $translatable = ['ques'];

    /**
     * factor relationship
     * @return BelongsTo
     */
    public function factor(): BelongsTo
    {
        return $this->belongsTo(Factor::class, 'factor_id', 'id');
    }


}
