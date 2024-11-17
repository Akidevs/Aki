<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Get the order that owns the review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}