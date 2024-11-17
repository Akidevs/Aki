<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'renter_id',
        'product_id',
        'quantity',
    ];

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}