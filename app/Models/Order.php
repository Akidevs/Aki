<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Update;
use App\Models\Review;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'renter_id',
        'product_id',
        'status',
        'start_date',
        'end_date',
        'proof_path',
        // Add other necessary fields
    ];

    /**
     * Get the renter who placed the order.
     */
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    /**
     * Get the product associated with the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the updates related to the order.
     */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Get the review associated with the order.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the payment associated with the order.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}