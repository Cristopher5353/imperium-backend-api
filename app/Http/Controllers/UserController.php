<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function saveUser(Request $request) {
        
    }

    public function getUserById(int $id) {
        $response = $this->userService->getUserById($id);

        return response()->json($response);
    }
}   
