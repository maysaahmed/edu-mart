<?php

namespace Modules\Organizations\Domain\Entities\Organization;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Modules\TechnicalAssessment\Domain\Entities\OrganizationAssessment;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

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
            get: fn ($value) => $value ? 'active' : 'blocked',
        );
    }

    /**
     * @return BelongsToMany
     */
    public function hiddenCourse(): BelongsToMany
    {
        return $this->belongsToMany('Modules\Courses\Domain\Entities\Course', 'hidden_courses', 'organization_id', 'course_id');
    }

    /**
     * assessments relationship
     * @return BelongsToMany
     */
    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'organization_assessment')
            ->using(OrganizationAssessment::class); // <— pivot model
    }
}
