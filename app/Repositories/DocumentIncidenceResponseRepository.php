<?php

namespace App\Repositories;

use App\Models\DocumentIncidenceResponse;

class DocumentIncidenceResponseRepository {
    public function saveDocumentIncidenceResponse(DocumentIncidenceResponse $documentIncidenceResponse) {
        $documentIncidenceResponse->save();
    }

    public function getDocumentIncidenceResponseById(int $id) {
        return DocumentIncidenceResponse::find($id);
    }
}