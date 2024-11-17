<?php

namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Add HasRoles here

    // Existing properties and methods

    use Notifiable;

    // Relationships
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function products()
{
    return $this->hasMany(Product::class, 'owner_id');
}

public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

public function orders()
{
    return $this->hasMany(Order::class, 'renter_id');
}

public function updates()
{
    return $this->hasMany(Update::class, 'user_id');
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    
}