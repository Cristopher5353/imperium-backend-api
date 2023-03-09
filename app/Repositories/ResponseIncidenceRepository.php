<?php

namespace App\Repositories;

use DB;
use App\Models\ResponseIncidence;

class ResponseIncidenceRepository {
    public function saveResponseIncidence(ResponseIncidence $responseIncidence) {
        $responseIncidence->save();
    }

    public function getResponseIncidenceDetailById(int $id) {
        $incidenceResponseDetail = DB::table('incidents_responses')
                    ->leftJoin('documents_incidents_responses', 'incidents_responses.id', 'documents_incidents_responses.incidence_response_id')
                    ->select('incidents_responses.response AS response', DB::raw('GROUP_CONCAT(DISTINCT documents_incidents_responses.id) AS id_documents'))
                    ->where('incidents_responses.incidence_id', '=', $id)
                    ->groupBy('incidents_responses.response')
                    ->first();

        return $incidenceResponseDetail;
    }
}