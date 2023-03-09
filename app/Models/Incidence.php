<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    use HasFactory;

    protected $table = 'incidents';

    protected $fillable = [
        'title',
        'subcategory_id',
        'priority_id',
        'description',
        'date_assignment',
        'deadline',
        'user_id'
    ];
}
