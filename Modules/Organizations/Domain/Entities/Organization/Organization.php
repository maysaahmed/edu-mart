<?php

namespace Modules\Organizations\Domain\Entities\Organization;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'address', 'status'];


    protected static function newFactory()
    {
        return \Modules\Organizations\Database\factories\OrganizationFactory::new();
    }

    /**
     * Get the status of the organization.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'active' : 'inactive',
        );
    }


}
