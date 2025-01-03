<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLogin extends Model
{
    use HasFactory;

    protected $table = 'vendor_login';  // Specify the table name

    protected $fillable = [
        'shop_name',
        'username',
        'mobile_no',
        'email',
        'address',
        'pincode',
        'vendor_type',
        'gst_no',
        'pan_no',
        'approval_status',
        'is_customization',
        'c_date',
        'password',
        'genders',
        'in_designer',
        'description',
    ];
}

