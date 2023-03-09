<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentIncidenceResponse extends Model
{
    use HasFactory;

    protected $table = 'documents_incidents_responses';

    protected $fillable = [
        'document',
        'incidence_response_id'
    ];
}
