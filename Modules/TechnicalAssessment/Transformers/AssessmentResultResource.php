<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Organizations\Domain\Entities\Organization\Organization;

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

        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'score' => $this->score,
            'organization_id' => $organization ? $organization->id : null,
            'organization' => $organization ? $organization->name : null,
            'tier' => $tier ? new AssessmentTierResource($tier) : null,
        ];
    }
}
