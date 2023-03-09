<?php

namespace App\Repositories;

use App\Models\Priority;

class PriorityRepository {
    public function getPriorities() {
        return Priority::all();
    }

    public function getPrioritiesActive() {
        return Priority::where('state', 1)->get();
    }

    public function getPriorityById(int $id) {
        return Priority::find($id);
    }

    public function savePriotiry(Priority $priority) {
        $priority->save();
    }

    public function updatePriority(Priority $priority) {
        $priority->update();
    }
}