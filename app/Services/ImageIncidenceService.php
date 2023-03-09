<?php

namespace App\Services;

use App\Repositories\ImageIncidenceRepository;

class ImageIncidenceService {
    protected $imageIncidenceRepository;

    public function __construct(ImageIncidenceRepository $imageIncidenceRepository) {
        $this->imageIncidenceRepository = $imageIncidenceRepository;
    }

    public function getImageIncidenceById(int $id) {
        $imageIncidence = $this->imageIncidenceRepository->getImageIncidenceById($id);

        return [
            "status" => 200,
            "message" => "Imagen",
            "data" => $imageIncidence
        ];
    }
}