<?php

namespace App\Repositories;

use App\Models\ImageIncidence;

class ImageIncidenceRepository {
    public function saveImageIncidence(ImageIncidence $imageIncidence) {
        $imageIncidence->save();
    }

    public function getImageIncidenceById(int $id) {
        return ImageIncidence::find($id);
    }
}