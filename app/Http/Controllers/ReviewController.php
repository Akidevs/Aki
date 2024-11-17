<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order; // Add this line
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Owner,Renter']);
    }

    // Show form to create a review
    public function createReview($orderId)
    {
        // Ensure the user is part of the order
        $order = Order::findOrFail($orderId);
        if ($order->renter_id !== Auth::id() && $order->product->owner_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.create', compact('order'));
    }

    // Store the review
    public function storeReview(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Ensure the user is part of the order
        if ($order->renter_id !== Auth::id() && $order->product->owner_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $reviewData = [
            'product_id' => $order->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if (Auth::id() === $order->renter_id) {
            $reviewData['renter_id'] = Auth::id();
            $reviewData['owner_id'] = $order->product->owner_id;
        } else {
            $reviewData['owner_id'] = Auth::id();
            $reviewData['renter_id'] = $order->renter_id;
        }

        Review::create($reviewData);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    // Additional review functionalities can be added here
}