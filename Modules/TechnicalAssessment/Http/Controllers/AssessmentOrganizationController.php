<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentOrganizationRequest;
use Modules\TechnicalAssessment\Http\Requests\UnassignAssessmentOrganizationRequest;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\EditAssessmentOrganization;
use Symfony\Component\HttpFoundation\Response;
use App\Enums;

class AssessmentOrganizationController extends ApiController
{

    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::assignAssessmentOrganization->value,   ['only' => ['assignAssessmentToOrganization', 'unassignAssessmentFromOrganization', 'update']]);
    }

    /**
     *
     * @param AssessmentOrganizationRequest $request
     * @param AssignAssessmentToOrganization\IAssignAssessmentToOrganization $command
     * @return JsonResponse
     */
    public function assignAssessmentToOrganization(AssessmentOrganizationRequest $request, AssignAssessmentToOrganization\IAssignAssessmentToOrganization $command): JsonResponse
    {
        try {
            $commandModel = AssignAssessmentToOrganization\AssignAssessmentToOrganizationModel::from($request->all());

            $assigned = $command->execute($commandModel);
            if($assigned)
                return $this->successResponse([],'Assessment assigned successfully!' , Response::HTTP_CREATED);
            else
                return $this->errorResponse('Something went wrong');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     *
     * @param UnassignAssessmentOrganizationRequest $request
     * @param UnassignAssessmentFromOrganization\IUnassignAssessmentFromOrganization $command
     * @return JsonResponse
     */
    public function unassignAssessmentFromOrganization(UnassignAssessmentOrganizationRequest $request, UnassignAssessmentFromOrganization\IUnassignAssessmentFromOrganization $command): JsonResponse
    {
        try {
            $commandModel = UnassignAssessmentFromOrganization\UnassignAssessmentFromOrganizationModel::from($request->all());

            $result = $command->execute($commandModel);
            if($result)
                return $this->successResponse([],'Assessment unassigned successfully!' , Response::HTTP_CREATED);
            else
                return $this->errorResponse('Something went wrong');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param AssessmentOrganizationRequest $request
     * @param int $id
     * @param EditAssessmentOrganization\IEditAssessmentOrganization $command
     * @return JsonResponse
     */
    public function update(AssessmentOrganizationRequest $request, int $id, EditAssessmentOrganization\IEditAssessmentOrganization $command): JsonResponse
    {
        try {
            $commandModel = EditAssessmentOrganization\EditAssessmentOrganizationModel::from($request->all()+['id' => $id]);

            $updated = $command->execute($commandModel);
            if($updated)
                return $this->successResponse([],'Data updated successfully!' , Response::HTTP_CREATED);
            else
                return $this->errorResponse('Something went wrong');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


}
