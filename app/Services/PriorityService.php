<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PriorityRepository;
use App\Models\Priority;
use App\Custom\ValidateExistById;
use App\Custom\TotalPages;

class PriorityService {
    protected $priorityRepository;

    public function __construct(PriorityRepository $priorityRepository) {
        $this->priorityRepository = $priorityRepository;
    }

    public function getPrioritiesAll() {
        $prioritiesAll = $this->priorityRepository->getPrioritiesAll();

        return [
            "status" => 200,
            "message" => "Listado de prioridades",
            "data" => $prioritiesAll,
        ];
    }

    public function getPriorities(int $page) {
        $prioritiesAll = $this->priorityRepository->getPrioritiesAll();
        $priorities = $this->priorityRepository->getPriorities($page);
        $totalPages = TotalPages::totalPages($prioritiesAll->count());

        return [
            "status" => 200,
            "message" => "Listado de prioridades",
            "data" => $priorities,
            "totalPages" => $totalPages
        ];
    }

    public function getPrioritiesActive() {
        $priorities = $this->priorityRepository->getPrioritiesActive();

        return [
            "status" => 200,
            "message" => "Listado de prioridades activas",
            "data" => $priorities
        ];
    }

    public function getPriorityById(int $id) {
        $response = ValidateExistById::validateExistById($id, "priorities", "Prioridad");

        if($response[0]["confirm"]) return $response[1];

        $priority = $this->priorityRepository->getPriorityById($id);

        return [
            "status" => 200,
            "message" => "Prioridad enviada correctamente",
            "data" => $priority
        ];
    }

    public function savePriority(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al registrar la prioridad",
                "data" => [$validator->errors()]
            ];
        }

        $priority = new Priority();
        $priority->name = $request->name;
        $priority->state = 1;

        $this->priorityRepository->savePriotiry($priority);

        return [
            "status" => 201,
            "message" => "Prioridad registrada correctamente",
            "data" => []
        ];
    }

    public function updatePriority(Request $request, int $id) {
        $response = ValidateExistById::validateExistById($id, "priorities", "Prioridad");

        if($response[0]["confirm"]) return $response[1];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al actualizar la prioridad",
                "data" => [$validator->errors()]
            ];
        }

        $priority = $this->priorityRepository->getPriorityById($id);
        $priority->name = $request->name;

        $this->priorityRepository->updatePriority($priority);

        return [
            "status" => 200,
            "message" => "Prioridad actualizada correctamente",
            "data" => []
        ];
    }

    public function changeStatePriority(int $id) {
        $response = ValidateExistById::validateExistById($id, "priorities", "Prioridad");

        if($response[0]["confirm"]) return $response[1];

        $priority = $this->priorityRepository->getPriorityById($id);
        $priority->state = ($priority->state == 1) ?0 :1;

        $this->priorityRepository->updatePriority($priority);

        return [
            "status" => 200,
            "message" => "Prioridad actualizada correctamente",
            "data" => []
        ];
    }
}