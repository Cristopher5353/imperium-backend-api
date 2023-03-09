<?php

namespace App\Repositories;

use App\Models\User;
use DB;

class UserRepository {
    public function saveUser(User $user) {
        $user->save();
    }

    public function getUserById(int $id) {
        $user = DB::table('users')
                ->join('roles', 'users.role_id', 'roles.id')
                ->select('users.id AS id', DB::raw('CONCAT(users.name, " ", users.first_surname, " ", users.last_surname) AS name'), 'roles.name AS role')
                ->where('users.id', '=', $id)
                ->first();

        return $user;
    }
}