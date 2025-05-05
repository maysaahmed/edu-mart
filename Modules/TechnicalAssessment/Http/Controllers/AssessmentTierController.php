<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentTierRequest;
use Modules\TechnicalAssessment\Transformers\AssessmentTierResource;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\DeleteAssessmentTier;
use Modules\TechnicalAssessment\Core\Assessment\Queries\CheckAssessmentEditable;
use Symfony\Component\HttpFoundation\Response;
use App\Enums;

class AssessmentTierController extends ApiController
{
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createAssessmentTier->value,   ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editAssessmentTier->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteAssessmentTier->value,   ['only' => ['destroy']]);
    }

    /**
     * Store a newly created resource in storage.
     * @param AssessmentTierRequest $request
     * @param CreateAssessmentTier\ICreateAssessmentTier $command
     * @param CheckAssessmentEditable\ICheckAssessmentEditable $query
     * @return JsonResponse
     */
    public function store(AssessmentTierRequest $request, CreateAssessmentTier\ICreateAssessmentTier $command, CheckAssessmentEditable\ICheckAssessmentEditable $query): JsonResponse
    {
        try {
            $canEditAssessment = $query->execute($request->assessment_id);
            if($canEditAssessment)
            {
                $commandModel = CreateAssessmentTier\CreateAssessmentTierModel::from($request->all());

                $result = $command->execute($commandModel);
                return $this->successResponse(new AssessmentTierResource($result),'Tier saved successfully!' , Response::HTTP_CREATED);

            }else{
                return $this->errorResponse('You cann\'t add tiers to this assessment.');
            }

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param AssessmentTierRequest $request
     * @param int $id
     * @param EditAssessmentTier\IEditAssessmentTier $command
     * @param CheckAssessmentEditable\ICheckAssessmentEditable $query
     * @return JsonResponse
     */
    public function update(AssessmentTierRequest $request, int $id, EditAssessmentTier\IEditAssessmentTier $command, CheckAssessmentEditable\ICheckAssessmentEditable $query): JsonResponse
    {
        try{
            $canEditAssessment = $query->execute($request->assessment_id);
            if($canEditAssessment) {
                $commandModel = EditAssessmentTier\EditAssessmentTierModel::from($request->all() + ['id' => $id]);
                $item = $command->execute($commandModel);
                return $this->successResponse(new AssessmentTierResource($item), 'Tier updated successfully!', Response::HTTP_ACCEPTED);
            }else{
                return $this->errorResponse('You cann\'t update tiers of this assessment.');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteAssessmentTier\IDeleteAssessmentTier $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteAssessmentTier\IDeleteAssessmentTier $command):JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Tier removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
