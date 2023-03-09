<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentIncidence extends Model
{
    use HasFactory;

    protected $table = 'documents_incidents';

    protected $fillable = [
        'document',
        'incidence_id'
    ];
}
