<?php

namespace App\Custom;

use Illuminate\Support\Facades\Validator;

class ValidateExistById {
    public static function validateExistById(int $id, string $table, string $message) {
        $validator = Validator::make(["id" => $id], [
            'id' => 'exists:'.$table.',id'
        ]);

        if($validator->fails()){
            return [
                    ["confirm" => true],
                    [
                        "status" => 404,
                        "message" => $message . " no encontrado(a)",
                        "data" => []
                    ]
                ];
        }

        return [["confirm" => false]];
    }
}