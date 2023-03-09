<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResponseIncidenceService;

class ResponseIncidenceController extends Controller {
    protected $responseIncidenceService;

    public function __construct(ResponseIncidenceService $responseIncidenceService) {
        $this->responseIncidenceService = $responseIncidenceService;
    }

    public function saveIncidenceResponse(Request $request, int $id) {
        $response = $this->responseIncidenceService->saveIncidenceResponse($request, $id);

        return response()->json($response);
    }

    public function getResponseIncidenceDetailById(int $id) {
        $response = $this->responseIncidenceService->getResponseIncidenceDetailById($id);

        return response()->json($response);
    }
}
