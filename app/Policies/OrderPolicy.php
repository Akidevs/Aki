<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order)
    {
        return $user->id === $order->renter_id || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the order.
     */
    public function update(User $user, Order $order)
    {
        return $user->id === $order->renter_id || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can review the order.
     */
    public function review(User $user, Order $order)
    {
        return $user->id === $order->renter_id && $order->status === 'completed';
    }

    // Add other authorization methods as needed
}