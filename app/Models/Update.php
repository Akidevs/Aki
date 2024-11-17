<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Update extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'content',
    ];

    /**
     * Get the order that owns the update.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who made the update.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}