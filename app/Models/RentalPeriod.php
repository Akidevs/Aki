<?php

// app/Models/RentalPeriod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPeriod extends Model
{
    protected $fillable = [
        'order_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}