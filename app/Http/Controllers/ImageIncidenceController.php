<?php

namespace App\Http\Controllers;

use App\Services\ImageIncidenceService;

class ImageIncidenceController extends Controller {
    protected $imageIncidenceService;

    public function __construct(ImageIncidenceService $imageIncidenceService) {
        $this->imageIncidenceService = $imageIncidenceService;
    } 

    public function getImageIncidenceById(int $id) {
        $response = $this->imageIncidenceService->getImageIncidenceById($id);

        return response()->json($response);
    }
}