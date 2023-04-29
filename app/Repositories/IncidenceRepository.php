<?php

namespace App\Repositories;

use DB;
use App\Models\Incidence;
use App\Custom\NumberRows;

class IncidenceRepository {

    public function getIncidents(int $page, int $categoryId, int $priorityId, int $userId) {
        if($userId == 0) {
            $incidents = DB::table('incidents')
                        ->join('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->join('priorities', 'incidents.priority_id', 'priorities.id')
                        ->select('incidents.id AS id', 'incidents.title AS title', 'categories.name AS category', 'priorities.name AS priority',
                                'incidents.description AS description', 'incidents.created_at AS created_at','incidents.date_assignment AS date_assignment', 'incidents.deadline AS deadline',
                                'incidents.user_id AS user')
                        ->whereRaw('(categories.id = ' . $categoryId . ' OR ' . $categoryId . ' = 0) AND (priorities.id = ' . $priorityId . ' OR ' . $priorityId . ' = 0)')
                        ->orderBy('incidents.created_at', 'DESC')
                        ->skip($page * NumberRows::numberRows())
                        ->limit(NumberRows::numberRows())
                        ->get();

            return $incidents;
        } else {
            $incidents = DB::table('incidents')
                        ->join('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->join('priorities', 'incidents.priority_id', 'priorities.id')
                        ->select('incidents.id AS id', 'incidents.title AS title', 'categories.name AS category', 'priorities.name AS priority',
                                'incidents.description AS description', 'incidents.created_at AS created_at','incidents.date_assignment AS date_assignment', 'incidents.deadline AS deadline',
                                'incidents.user_id AS user')
                        ->whereRaw('(categories.id = ' . $categoryId . ' OR ' . $categoryId . ' = 0) AND (priorities.id = ' . $priorityId . ' OR ' . $priorityId . ' = 0) AND (incidents.user_id = ' . $userId . ')')
                        ->orderBy('incidents.created_at', 'DESC')
                        ->skip($page * NumberRows::numberRows())
                        ->limit(NumberRows::numberRows())
                        ->get();
                        
            return $incidents;
        }
    }

    public function getIncidentsAllByUserIdZero(int $categoryId, int $priorityId) {
        $incidents = DB::table('incidents')
                        ->join('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->join('priorities', 'incidents.priority_id', 'priorities.id')
                        ->select('incidents.id AS id', 'incidents.title AS title', 'categories.name AS category', 'priorities.name AS priority',
                                'incidents.description AS description', 'incidents.created_at AS created_at','incidents.date_assignment AS date_assignment', 'incidents.deadline AS deadline',
                                'incidents.user_id AS user')
                        ->whereRaw('(categories.id = ' . $categoryId . ' OR ' . $categoryId . ' = 0) AND (priorities.id = ' . $priorityId . ' OR ' . $priorityId . ' = 0)')
                        ->orderBy('incidents.created_at', 'DESC')
                        ->get();

        return $incidents;
    }

    public function getIncidentsAllByUserIdDiferentZero(int $categoryId, int $priorityId, int $userId) {
        $incidents = DB::table('incidents')
                        ->join('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->join('priorities', 'incidents.priority_id', 'priorities.id')
                        ->select('incidents.id AS id', 'incidents.title AS title', 'categories.name AS category', 'priorities.name AS priority',
                                'incidents.description AS description', 'incidents.created_at AS created_at','incidents.date_assignment AS date_assignment', 'incidents.deadline AS deadline',
                                'incidents.user_id AS user')
                        ->whereRaw('(categories.id = ' . $categoryId . ' OR ' . $categoryId . ' = 0) AND (priorities.id = ' . $priorityId . ' OR ' . $priorityId . ' = 0) AND (incidents.user_id = ' . $userId . ')')
                        ->orderBy('incidents.created_at', 'DESC')
                        ->get();
        
        return $incidents;
    }

    public function getIncidenceById(int $id) {
        return Incidence::find($id);
    }

    public function getIncidentsByUser(int $userId) {
        $incidents = DB::table('incidents')
                    ->join('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                    ->join('categories', 'subcategories.category_id', 'categories.id')
                    ->join('priorities', 'incidents.priority_id', 'priorities.id')
                    ->select('incidents.id AS id', 'categories.name AS category', 'incidents.title AS title', 'priorities.name AS priority',
                             'incidents.created_at AS created_at','incidents.date_assignment AS date_assignment', 'incidents.deadline AS deadline',
                             'incidents.user_id AS user')
                    ->where('incidents.user_id', '=', $userId)
                    ->orderBy('incidents.created_at', 'DESC')->get();

        return $incidents;
    }

    public function saveIncidence(Incidence $incidence) {
        $incidence->save();
    }

    public function getDetailIncidenceById(int $id) {
        $incidence = DB::table('incidents')
                    ->leftJoin('users', 'incidents.user_id', 'users.id')
                    ->leftJoin('documents_incidents', 'incidents.id', 'documents_incidents.incidence_id')
                    ->leftJoin('images_incidents', 'incidents.id', 'images_incidents.incidence_id')
                    ->select('incidents.id AS id', DB::raw('CONCAT(users.name, " ", users.first_surname, " ", users.last_surname) AS technical'),
                             'incidents.title AS title', 'incidents.description AS description', 'incidents.created_at AS created_at', 'incidents.deadline',
                             DB::raw('GROUP_CONCAT(DISTINCT documents_incidents.id) AS id_documents'),
                             DB::raw('GROUP_CONCAT(DISTINCT images_incidents.id) AS id_images'))
                    ->where('incidents.id', '=', $id)
                    ->groupBy('incidents.id', 'users.name', 'users.first_surname', 'users.last_surname', 'incidents.title', 'incidents.created_at')
                    ->first();

        return $incidence;
    }
    
    public function updateIncidence(Incidence $incidence) {
        $incidence->update();
    }

    public function getSupportUsersWithAssignIncidentsQuantity() {
        $supportUsers = DB::table('users')
                        ->leftjoin('incidents', 'users.id', 'incidents.user_id')
                        ->select('users.id', 'users.name', 'users.last_surname', 'users.first_surname', DB::raw('COUNT(incidents.id) AS quantity'))
                        ->where('users.role_id', '=', 2)
                        ->groupBy('users.id')
                        ->get();

        return $supportUsers;
    }

    public function getTotalIncidents() {
        $total = DB::table('incidents')->get()->count();
        return $total;
    }

    public function getTotalOpenIncidents() {
        $total = DB::table('incidents')
                ->whereRaw('ISNULL(deadline) = true')
                ->get()
                ->count();
                
        return $total;
    }

    public function getTotalCloseIncidents() {
        $total = DB::table('incidents')
                ->whereRaw('ISNULL(deadline) = false')
                ->get()
                ->count();

        return $total;
    }

    public function getTotalIncidentsByCategory() {
        $incidents = DB::table('incidents')
                    ->rightjoin('subcategories', 'incidents.subcategory_id', 'subcategories.id')
                    ->rightjoin('categories', 'subcategories.category_id', 'categories.id')
                    ->select('categories.name AS name', DB::raw('COUNT(incidents.id) AS quantity'))
                    ->groupBy('categories.name')
                    ->get();

        return $incidents;
    }
}
