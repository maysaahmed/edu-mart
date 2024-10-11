<?php

namespace Modules\Assessment\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'factor_id', 'result'];


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
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Entities\User\User::class, 'user_id', 'id');
    }


}
