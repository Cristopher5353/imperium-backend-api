<?php

namespace App\Http\Controllers;

use App\Services\DocumentIncidenceService;

class DocumentIncidenceController extends Controller {
    protected $documentIncidenceService;

    public function __construct(DocumentIncidenceService $documentIncidenceService) {
        $this->documentIncidenceService = $documentIncidenceService;
    }  

    public function getDocumentIncidenceById(int $id) {
        $response = $this->documentIncidenceService->getDocumentIncidenceById($id);

        return response()->json($response);
    }
}