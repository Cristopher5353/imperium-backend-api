<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentIncidenceResponseService;

class DocumentIncidenceResponseController extends Controller {
    protected $documentIncidenceResponseService;

    public function __construct(DocumentIncidenceResponseService $documentIncidenceResponseService) {
        $this->documentIncidenceResponseService = $documentIncidenceResponseService;
    }  

    public function getDocumentIncidenceResponseById(int $id) {
        $response = $this->documentIncidenceResponseService->getDocumentIncidenceResponseById($id);

        return response()->json($response);
    }
}