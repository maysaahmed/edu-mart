<?php

namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserAssessmentsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $userId = auth()->id();
        $hasTaken = false;
        $canRetake = true;
        $nextRetakeIn = null;

        if ($userId) {
            $latestResult = $this->results()
                ->where('user_id', $userId)
                ->orderByDesc('submitted_at')
                ->first();

            $hasTaken = isset($latestResult) ?? false;

            if ($latestResult && $latestResult->submitted_at) {
                $retakeDays = config('assessment.retake_days', 30);
                $nextAllowed = Carbon::parse($latestResult->submitted_at)->addDays($retakeDays);

                if (now()->lt($nextAllowed)) {
                    $canRetake = false;
                    $nextRetakeIn = $nextAllowed->diffInDays(now());
                }
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'type' => $this->assessment_type,
            'has_taken' => $hasTaken,
            'can_retake' => $canRetake,
            'retake_after_days' => $nextRetakeIn,


        ];
    }
}
