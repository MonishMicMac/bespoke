<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'user_login';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    // Indicates if the IDs are auto-incrementing.
    public $incrementing = true;

    // The attributes that are mass assignable.
    protected $fillable = [
        'username',
        'mobile',
        'email',
        'password',
        'otp',
        'address',
        'pincode',
        'c_date',
        'action',
    ];

    // The attributes that should be hidden for arrays (e.g., password).
    protected $hidden = [
        'password', // Make sure to hide the password when converting to an array or JSON.
        'otp',      // You can choose to hide OTP as well.
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'c_date' => 'datetime', // Ensure 'c_date' is cast as a datetime.
    ];
}
