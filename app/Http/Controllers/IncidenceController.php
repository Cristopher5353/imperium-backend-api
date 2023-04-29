<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IncidenceService;

class IncidenceController extends Controller
{
    protected $incidenceService;

    public function __construct(IncidenceService $incidenceService) {
        $this->incidenceService = $incidenceService;
    }

    public function getIncidents(int $page, int $categoryId, int $priorityId, int $userId) {
        $response = $this->incidenceService->getIncidents($page, $categoryId, $priorityId, $userId);

        return response()->json($response);
    }

    public function getIncidentsByUser(int $userId) {
        $response = $this->incidenceService->getIncidentsByUser($userId);

        return response()->json($response);
    }

    public function saveIncidence(Request $request)  {
        $response = $this->incidenceService->saveIncidence($request);

        return response()->json($response);
    }

    public function getDetailIncidenceById(int $id) {
        $response = $this->incidenceService->getDetailIncidenceById($id);

        return response()->json($response);
    } 

    public function deleteAssignedUserIncidence(int $id) {
        $response = $this->incidenceService->deleteAssignedUserIncidence($id);

        return response()->json($response);
    }

    public function assignUserTechnicalIncidence(Request $request, int $id) {
        $response = $this->incidenceService->assignUserTechnicalIncidence($request, $id);

        return response()->json($response);
    }

    public function getSupportUsersWithAssignIncidentsQuantity() {
        $response = $this->incidenceService->getSupportUsersWithAssignIncidentsQuantity();

        return response()->json($response);
    }

    public function getTotalIncidents() {
        $response = $this->incidenceService->getTotalIncidents();

        return response()->json($response);
    }

    public function getTotalOpenIncidents() {
        $response = $this->incidenceService->getTotalOpenIncidents();

        return response()->json($response);
    }

    public function getTotalCloseIncidents() {
        $response = $this->incidenceService->getTotalCloseIncidents();

        return response()->json($response);
    }

    public function getTotalIncidentsByCategory() {
        $response = $this->incidenceService->getTotalIncidentsByCategory();

        return response()->json($response);
    }

    // public function saveIncidenceResponse(Request $request, int $id) {
    //     $response = $this->incidenceService->saveIncidenceResponse($request, $id);

    //     return response()->json($response);
    // }

    // public function getResponseIncidenceDetailById(int $id) {
    //     $response = $this->incidenceService->getResponseIncidenceDetailById($id);

    //     return response()->json($response);
    // }
}
