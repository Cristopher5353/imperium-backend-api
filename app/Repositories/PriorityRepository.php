<?php

namespace App\Repositories;

use DB;
use App\Models\Priority;
use App\Custom\NumberRows;

class PriorityRepository {
    
    public function getPrioritiesAll() {
        return Priority::all();
    }

    public function getPriorities(int $page) {
        $priorities = DB::table('priorities')
                        ->select('priorities.id', 'priorities.name', 'priorities.state', 'priorities.created_at', 'priorities.updated_at')
                        ->skip($page * NumberRows::numberRows())
                        ->limit(NumberRows::numberRows())
                        ->get();
        return $priorities;
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