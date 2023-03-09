<?php

namespace App\Services;

use App\Repositories\DocumentIncidenceResponseRepository;

class DocumentIncidenceResponseService {
    protected $documentIncidenceResponseRepository;
    
    public function __construct(DocumentIncidenceResponseRepository $documentIncidenceResponseRepository) {
        $this->documentIncidenceResponseRepository = $documentIncidenceResponseRepository;
    }

    public function getDocumentIncidenceResponseById(int $id) {
        $documentIncidenceResponse = $this->documentIncidenceResponseRepository->getDocumentIncidenceResponseById($id);

        return [
            "status" => 200,
            "message" => "Documento",
            "data" => $documentIncidenceResponse
        ];
    }
}