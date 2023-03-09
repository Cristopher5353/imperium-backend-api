<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageIncidence extends Model
{
    use HasFactory;

    protected $table = 'images_incidents';

    protected $fillable = [
        'image',
        'incidence_id'
    ];
}
