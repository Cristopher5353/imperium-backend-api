<?php

namespace App\Services;

use App\Repositories\DocumentIncidenceRepository;

class DocumentIncidenceService {
    protected $documentIncidenceRepository;

    public function __construct(DocumentIncidenceRepository $documentIncidenceRepository) {
        $this->documentIncidenceRepository = $documentIncidenceRepository;
    }

    public function getDocumentIncidenceById(int $id) {
        $documentIncidence = $this->documentIncidenceRepository->getDocumentIncidenceById($id);

        return [
            "status" => 200,
            "message" => "Documento",
            "data" => $documentIncidence
        ];
    }
}