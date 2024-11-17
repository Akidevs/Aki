<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'price',
        'status',
        'image_path',
    ];

    /**
     * Get the owner of the product.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}