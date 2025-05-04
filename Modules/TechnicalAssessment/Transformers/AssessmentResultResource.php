<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Organizations\Domain\Entities\Organization\Organization;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

class AssessmentResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $email = $this->user->email ?? null;

        $domain = $email ? substr(strrchr($email, "@"), 1) : null;

        $organization = Organization::where('domain', $domain)->first();

        $tier = null;

        if ($this->score && $this->assessment && $this->assessment->tiers) {
            $tier = $this->assessment->tiers
                ->firstWhere(fn($t) => $this->score >= $t->from && $this->score <= $t->to);
        }

        $totalWeight = AssessmentQuestion::where('assessment_id', $this->assessment_id)->sum('weight');
        $percentage = $totalWeight > 0
            ? round(($this->score / $totalWeight) * 100, 2)
            : 0;

        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'email' => $this->user->name,
            'score' => $this->score,
            'percentage' => $percentage.'%',
            'date' => $this->submitted_at,
            'organization_id' => $organization ? $organization->id : null,
            'organization' => $organization ? $organization->name : null,
            'tier' => $tier ? new AssessmentTierResource($tier) : null,
        ];
    }
}
