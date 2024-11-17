<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function approveProduct($id)
{
    $product = Product::findOrFail($id);
    $product->status = 'approved';
    $product->save();

    // Optionally, notify the owner about approval
    // $product->owner->notify(new ProductApprovedNotification($product));

    return redirect()->route('admin.pending-products')->with('success', 'Product approved successfully.');
}

public function rejectProduct($id)
{
    $product = Product::findOrFail($id);
    $product->status = 'rejected';
    $product->save();

    // Optionally, notify the owner about rejection
    // $product->owner->notify(new ProductRejectedNotification($product));

    return redirect()->route('admin.pending-products')->with('success', 'Product rejected successfully.');
}
    /**
     * Display a list of pending products awaiting approval.
     */
    public function pendingProducts()
    {
        $products = Product::where('status', 'pending')->with('owner')->get();
        return view('admin.pending-products', compact('products'));
    }

    /**
     * Approve a pending product.
     */
    
}