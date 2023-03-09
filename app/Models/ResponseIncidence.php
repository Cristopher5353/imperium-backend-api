<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseIncidence extends Model
{
    use HasFactory;

    protected $table = 'incidents_responses';

    protected $fillable = [
        'response',
        'incidence_id',
    ];
}
