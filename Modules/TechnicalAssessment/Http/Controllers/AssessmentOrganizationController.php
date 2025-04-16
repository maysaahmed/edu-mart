<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentOrganizationRequest;
use Modules\TechnicalAssessment\Http\Requests\UnassignAssessmentOrganizationRequest;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization;
use Symfony\Component\HttpFoundation\Response;
use App\Enums;

class AssessmentOrganizationController extends ApiController
{

    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::assignAssessmentOrganization->value,   ['only' => ['assignAssessmentToOrganization', 'unassignAssessmentFromOrganization']]);
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

            $result = $command->execute($commandModel);
            return $this->successResponse([],'Assessment assigned successfully!' , Response::HTTP_CREATED);

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
            return $this->successResponse([],'Assessment unassigned successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


}
