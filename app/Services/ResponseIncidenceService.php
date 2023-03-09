<?php

namespace App\Services;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ResponseIncidenceRepository;
use App\Repositories\DocumentIncidenceResponseRepository;
use App\Models\ResponseIncidence;
use App\Models\DocumentIncidenceResponse;

class ResponseIncidenceService {
    protected $responseIncidenceRepository;
    protected $documentIncidenceResponseRepository;

    public function __construct(ResponseIncidenceRepository $responseIncidenceRepository, DocumentIncidenceResponseRepository $documentIncidenceResponseRepository) {
        $this->responseIncidenceRepository = $responseIncidenceRepository;
        $this->documentIncidenceResponseRepository = $documentIncidenceResponseRepository;
    }

    public function saveIncidenceResponse(Request $request, int $id) {
        $validator = Validator::make($request->all(), [
            'response' => 'required|string|max:255',
            'documents.*' => 'file|mimes:pdf'
        ]);

        try {
            DB::beginTransaction();

            if($validator->fails()){
                return [
                    "status" => 400,
                    "message" => "Errores al registrar la respuesta a la incidencia",
                    "data" => [$validator->errors()]
                ];
            }

            $incidenceResponse = new ResponseIncidence();
            $incidenceResponse->response = $request->response;
            $incidenceResponse->incidence_id = $id;
            $this->responseIncidenceRepository->saveResponseIncidence($incidenceResponse);

            $incidence = $this->incidenceRepository->getIncidenceById($id);
            $incidence->deadline = date('Y-m-d');
            $this->incidenceRepository->updateIncidence($incidence);

            if($request->file("documents")) {
                foreach($request->file("documents") as $document) {
                    $nameDocument = "incidence_".time().$this->generateRandomString().'.'.$document->getClientOriginalExtension();;

                    $documentIncidenceResponse = new DocumentIncidenceResponse();
                    $documentIncidenceResponse->document = $nameDocument;
                    $documentIncidenceResponse->incidence_response_id = $incidenceResponse->id;

                    $this->documentIncidenceResponseRepository->saveDocumentIncidenceResponse($documentIncidenceResponse);
    
                    $document->storeAs('private/documents_response/', $nameDocument);
                }
            }
            
            DB::commit();

            return [
                "status" => 201,
                "message" => "Respuesta a incidencia registrada correctamente",
                "data" => []
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                "status" => 500,
                "message" => "Error, no se pudo registrar la respuesta de la incidencia",
                "data" => [$e->getMessage()]
            ];
        }
    }

    public function getResponseIncidenceDetailById(int $id) {
        $response = $this->responseIncidenceRepository->getResponseIncidenceDetailById($id);
        return [
            "status" => 200,
            "message" => "Respuesta de incidencia enviada correctamente",
            "data" => $response
        ];
    }

}