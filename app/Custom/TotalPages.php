<?php

namespace App\Custom;
use App\Custom\NumberRows;

class TotalPages {
    public static function totalPages(int $totalRegisters) {
        $totalPages = 0;

        if(($totalRegisters % NumberRows::numberRows()) == 0) {
            $totalPages = $totalRegisters / NumberRows::numberRows();
        } else {
            $totalPages = floor(($totalRegisters / NumberRows::numberRows())) + 1;
        }

        return $totalPages;
    }
}