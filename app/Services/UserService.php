<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Custom\ValidateExistById;

class UserService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function saveUser(Request $request) {
        
    }

    public function getUserById(int $id) {
        $response = ValidateExistById::validateExistById($id, "users", "Usuario");

        if($response[0]["confirm"]) return $response[1];

        $user = $this->userRepository->getUserById($id);

        return [
            "status" => 200,
            "message" => "Usuario enviado correctamente",
            "data" => $user
        ];
    }
}