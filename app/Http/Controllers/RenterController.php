<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Update;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class RenterController extends Controller
{
    public function confirmRent(Order $order)
{
    // Authorization: Ensure the renter owns the order
    $this->authorize('view', $order);

    return view('renter.rental.confirm-rent', compact('order'));
}

    /**
     * Display the product feed with approved products.
     */
    public function productFeed()
    {
        // Fetch approved products
        $products = Product::where('status', 'approved')->get();

        // Pass products to the view
        return view('renter.product-feed', compact('products'));
    }

    /**
     * Display detailed information about a specific product.
     */
    public function productInfo($id)
    {
        $product = Product::with('owner')->findOrFail($id);
        return view('renter.product-info', compact('product'));
    }

    /**
     * Display the renter's cart.
     */
    public function viewCart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('renter.cart.view', compact('cartItems'));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Optionally, increase quantity if applicable
            // $cartItem->quantity += 1;
            // $cartItem->save();
            return redirect()->route('renter.cart.view')->with('success', 'Product already in cart.');
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
            return redirect()->route('renter.cart.view')->with('success', 'Product added to cart.');
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function removeFromCart($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        $cartItem->delete();
        return redirect()->route('renter.cart.view')->with('success', 'Product removed from cart.');
    }

    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('renter.product-feed')->with('error', 'Your cart is empty.');
        }
        return view('renter.checkout', compact('cartItems'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function processCheckout(Request $request)
    {
        // Implement payment processing logic here (e.g., using Stripe)

        // After successful payment, create an order for each cart item
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        foreach ($cartItems as $item) {
            Order::create([
                'renter_id' => Auth::id(),
                'product_id' => $item->product_id,
                'status' => 'pending',
                // Add other necessary fields like rental period
            ]);
            $item->delete(); // Clear the cart
        }

        return redirect()->route('renter.product-feed')->with('success', 'Checkout successful. Your orders are pending confirmation.');
    }

    /**
     * Display the payment page.
     */
    public function payment()
    {
        // Implement payment view or redirect as necessary
        return view('renter.payment');
    }

    /**
     * Display the confirm rent form.
     */
    /**
     * Handle the submission of a daily update.
     */
    public function submitDailyUpdate(Request $request, Order $order)
    {
        // Authorization: Ensure the renter owns the order
        $this->authorize('update', $order);

        $request->validate([
            'update' => 'required|string|max:1000',
        ]);

        Update::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'content' => $request->update,
        ]);

        // Optionally, notify the owner about the new update
        // $order->product->owner->notify(new NewDailyUpdateNotification($order));

        return redirect()->route('renter.rental.daily-updates', $order->id)
                         ->with('success', 'Daily update submitted successfully.');
    }

    /**
     * Display the upload proof form.
     */
    public function uploadProof(Order $order)
    {
        // Authorization: Ensure the renter owns the order
        $this->authorize('update', $order);

        return view('renter.rental.upload-proof', compact('order'));
    }

    /**
     * Handle the upload of proof of transaction.
     */
    public function storeProof(Request $request, Order $order)
    {
        // Authorization
        $this->authorize('update', $order);

        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $proofPath = $request->file('proof')->store('proofs', 'public');

        $order->proof_path = $proofPath;
        $order->save();

        return redirect()->route('renter.rental.rent-started', $order->id)
                         ->with('success', 'Proof of transaction uploaded successfully.');
    }

    /**
     * Display the rent started page.
     */
    public function rentStarted(Order $order)
    {
        // Authorization
        $this->authorize('view', $order);

        $updates = $order->updates()->orderBy('created_at', 'desc')->get();

        return view('renter.rental.rent-started', compact('order', 'updates'));
    }

    /**
     * Display the device exchange form.
     */
    public function deviceExchange(Order $order)
    {
        // Authorization
        $this->authorize('update', $order);

        return view('renter.rental.device-exchange', compact('order'));
    }

    /**
     * Display the create review form.
     */
    public function createReview(Order $order)
    {
        // Authorization: Ensure the renter owns the order and it's completed
        $this->authorize('review', $order);

        return view('common.reviews.create', compact('order'));
    }

    /**
     * Store the submitted review.
     */
    public function storeReview(Request $request, Order $order)
    {
        // Authorization
        $this->authorize('review', $order);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Assuming you have a Review model
        Review::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(), // Renter
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Optionally, notify the owner about the new review
        // $order->product->owner->notify(new NewReviewNotification($order));

        return redirect()->route('common.reviews.list', $order->product_id)
                         ->with('success', 'Review submitted successfully.');
    }
}