<?php

namespace Modules\Assessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Option extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['text', 'weight'];
    public $translatable = ['text'];

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\OptionFactory::new();
    }


}
