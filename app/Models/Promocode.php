<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    // Specify the table name (if it's different from the plural form of the model)
    protected $table = 'promocode';  // This is correct if the table is named 'promocode'


    // Define which fields are mass assignable (columns in your table)
    protected $fillable = ['code', 'expire_date', 'discount_type', 'discount', 'from_date', 'to_date', 'action'];


    // Optionally, specify any date fields to be automatically cast as Carbon instances
    protected $dates = ['from_date', 'expire_date'];

    // You can optionally add mutators or accessors if you want custom date/time formats.
    // For example, formatting dates as Y-m-d

    public function getFromDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public function getExpireDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }


     /**
     * Check if a promo code exists with action = '0' and return relevant details.
     *
     * @param string $promoCode
     * @return array|null
     */
    public static function checkPromoCode($promoCode)
    {
        // Fetch the record by promo code where action is '0'
        $record = self::where('code', $promoCode)
                      ->where('action', '1')
                      ->first();

        // If a record is found, return the necessary details
        if ($record) {
            return [
                'from_date' => $record->from_date,
                'expire_date' => $record->expire_date,
                'discount_type' => $record->discount_type,
                'discount' => $record->discount,
            ];
        }

        return null;
    }
    
}
