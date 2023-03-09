<?php

namespace App\Repositories;

use App\Models\DocumentIncidence;

class DocumentIncidenceRepository {
    public function saveDocumentIncidence(DocumentIncidence $documentIncidence) {
        $documentIncidence->save();
    }

    public function getDocumentIncidenceById(int $id) {
        return DocumentIncidence::find($id);
    }
}