<?php

namespace App\Domain\Entities\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, HasPermissions;
    use SoftDeletes;

    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'type',
        'check_email_status',
        'email_verified_at',
        'is_active',
        'createdBy',
        'updatedBy',
        'deletedBy'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verifyUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('Modules\Users\Domain\Entities\VerifyUser', 'user_id', 'id');
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('Modules\Users\Domain\Entities\UserAccount', 'user_id', 'id');
    }

    public function organization(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo('Modules\Organizations\Domain\Entities\Organization\Organization', 'organization_id', 'id');
    }

}
