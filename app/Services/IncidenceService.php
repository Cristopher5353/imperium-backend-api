<?php

namespace App\Services;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\IncidenceRepository;
use App\Repositories\ImageIncidenceRepository;
use App\Repositories\DocumentIncidenceRepository;
use App\Models\Incidence;
use App\Models\ImageIncidence;
use App\Models\DocumentIncidence;
use App\Custom\ValidateExistById;
use App\Custom\TotalPages;

class IncidenceService {
    protected $incidenceRepository;
    protected $imageIncidenceRepository;
    protected $documentIncidenceRepository;

    public function __construct(IncidenceRepository $incidenceRepository, 
                                ImageIncidenceRepository $imageIncidenceRepository, 
                                DocumentIncidenceRepository $documentIncidenceRepository) {

        $this->incidenceRepository = $incidenceRepository;
        $this->imageIncidenceRepository = $imageIncidenceRepository;
        $this->documentIncidenceRepository = $documentIncidenceRepository;
    }

    public function getIncidents(int $page, int $categoryId, int $priorityId, int $userId) {
        $incidentsAll;

        if($userId == 0) {
            $incidentsAll = $this->incidenceRepository->getIncidentsAllByUserIdZero($categoryId, $priorityId);
        } else {
            $incidentsAll = $this->incidenceRepository->getIncidentsAllByUserIdDiferentZero($categoryId, $priorityId, $userId);
        }

        $incidents = $this->incidenceRepository->getIncidents($page, $categoryId, $priorityId, $userId);
        $totalPages = TotalPages::totalPages($incidentsAll->count());

        return [
            "status" => 200,
            "message" => "Listado de incidencias",
            "data" => $incidents,
            "totalPages" => $totalPages
        ];
    }

    public function getIncidentsByUser(int $userId) {
        $incidents = $this->incidenceRepository->getIncidentsByUser($userId);

        return [
            "status" => 200,
            "message" => "Listado de Incidencias asignadas por usuario",
            "data" => $incidents
        ];
    }

    public function saveIncidence(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'priority_id' => 'required|exists:priorities,id',
            'description' => 'required|max:2000000000',
            'images.*' => 'image|mimes:png,jpge,jpg',
            'documents.*' => 'file|mimes:pdf'
        ]);

        try {
            DB::beginTransaction();

            if($validator->fails()){
                return [
                    "status" => 400,
                    "message" => "Errores al registrar la incidencia",
                    "data" => [$validator->errors()]
                ];
            }

            $incidence = new Incidence();
            $incidence->title = $request->title;
            $incidence->subcategory_id = $request->subcategory_id;
            $incidence->priority_id = $request->priority_id;
            $incidence->description = $request->description;

            $this->incidenceRepository->saveIncidence($incidence);

            if($request->file("images")) {
                foreach($request->file("images") as $image) {
                    $nameImage = "incidence_".time().$this->generateRandomString().'.'.$image->getClientOriginalExtension();

                    $imageIncidence = new ImageIncidence();
                    $imageIncidence->image = $nameImage;
                    $imageIncidence->incidence_id = $incidence->id;

                    $this->imageIncidenceRepository->saveImageIncidence($imageIncidence);
    
                    $image->storeAs('private/images/', $nameImage);
                }
            }

            if($request->file("documents")) {
                foreach($request->file("documents") as $document) {
                    $nameDocument = "incidence_".time().$this->generateRandomString().'.'.$document->getClientOriginalExtension();;

                    $documentIncidence = new DocumentIncidence();
                    $documentIncidence->document = $nameDocument;
                    $documentIncidence->incidence_id = $incidence->id;

                    $this->documentIncidenceRepository->saveDocumentIncidence($documentIncidence);
    
                    $document->storeAs('private/documents/', $nameDocument);
                }
            }
            
            DB::commit();

            return [
                "status" => 201,
                "message" => "Incidencia registrada correctamente",
                "data" => []
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                "status" => 500,
                "message" => "Error, no se pudo registrar la incidencia",
                "data" => []
            ];
        }
    }

    public function getDetailIncidenceById(int $id) {
        $response = ValidateExistById::validateExistById($id, "incidents", "Incidencia");

        if($response[0]["confirm"]) return $response[1];

        $incidence = $this->incidenceRepository->getDetailIncidenceById($id);

        return [
            "status" => 200,
            "message" => "Incidencia enviada correctamente",
            "data" => $incidence
        ];
    }

    public function deleteAssignedUserIncidence(int $id) {
        $response = ValidateExistById::validateExistById($id, "incidents", "Incidencia");

        if($response[0]["confirm"]) return $response[1];

        $incidence = $this->incidenceRepository->getIncidenceById($id);
        $incidence->user_id = null;
        $incidence->date_assignment = null;

        $this->incidenceRepository->updateIncidence($incidence);

        return [
            "status" => 200,
            "message" => "Usuario asignado eliminado correctamente",
            "data" => []
        ];
    }

    public function assignUserTechnicalIncidence(Request $request, int $id) {
        $response = ValidateExistById::validateExistById($id, "incidents", "Incidencia");

        if($response[0]["confirm"]) return $response[1];

        $response = ValidateExistById::validateExistById($request->user_id, "users", "Usuario");

        if($response[0]["confirm"]) return $response[1];

        $incidence = $this->incidenceRepository->getIncidenceById($id);
        $incidence->user_id = $request->user_id;
        $incidence->date_assignment = date("Y-m-d");

        $this->incidenceRepository->updateIncidence($incidence);

        return [
            "status" => 200,
            "message" => "Usuario asignado a incidencia correctamente",
            "data" => []
        ];
    }

    public function getSupportUsersWithAssignIncidentsQuantity() {
        $response = $this->incidenceRepository->getSupportUsersWithAssignIncidentsQuantity();
        return [
            "status" => 200,
            "message" => "Listado de usuarios de soporte enviados correctamente",
            "data" => $response
        ];
    }

    public function getTotalIncidents() {
        $response = $this->incidenceRepository->getTotalIncidents();
        return [
            "status" => 200,
            "message" => "Total de incidencias",
            "data" => $response
        ];
    }

    public function getTotalOpenIncidents() {
        $response = $this->incidenceRepository->getTotalOpenIncidents();
        return [
            "status" => 200,
            "message" => "Total de incidencias abiertas",
            "data" => $response
        ];
    }

    public function getTotalCloseIncidents() {
        $response = $this->incidenceRepository->getTotalCloseIncidents();
        return [
            "status" => 200,
            "message" => "Total de incidencias cerradas",
            "data" => $response
        ];
    }

    public function getTotalIncidentsByCategory() {
        $response = $this->incidenceRepository->getTotalIncidentsByCategory();
        return [
            "status" => 200,
            "message" => "Total de incidencias por categoría",
            "data" => $response
        ];
    }

    function generateRandomString($length = 20) { 
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
    } 
}
