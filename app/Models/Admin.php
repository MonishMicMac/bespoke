<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = ['name', 'password', 'action'];

    // Disable timestamps if not using created_at/updated_at
    public $timestamps = false;
}
