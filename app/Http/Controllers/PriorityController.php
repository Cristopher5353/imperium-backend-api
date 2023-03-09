<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PriorityService;

class PriorityController extends Controller
{
    protected $priorityService;

    public function __construct(PriorityService $priorityService) {
        $this->priorityService = $priorityService;
    }

    public function getPriorities() {
        $response = $this->priorityService->getPriorities();

        return response()->json($response);
    }

    public function getPrioritiesActive() {
        $response = $this->priorityService->getPrioritiesActive();

        return response()->json($response);
    }

    public function getPriorityById(int $id) {
        $response = $this->priorityService->getPriorityById($id);

        return response()->json($response);
    }

    public function savePriority(Request $request) {
        $response = $this->priorityService->savePriority($request);

        return response()->json($response);
    }

    public function updatePriority(Request $request, int $id) {
        $response = $this->priorityService->updatePriority($request, $id);

        return response()->json($response);
    }

    public function changeStatePriority(int $id) {
        $response = $this->priorityService->changeStatePriority($id);

        return response()->json($response);
    }
}
