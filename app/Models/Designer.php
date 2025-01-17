<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    use HasFactory;

    protected $table = 'designer';
    protected $fillable = [
        'designer_name',
        'designer_image',
        'designer_title',
        'navigate',
        'searchfield_id',
        'searchfield_text'
    ];
}
