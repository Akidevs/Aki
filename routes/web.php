<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagingController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/pending-products', [AdminController::class, 'pendingProducts'])->name('admin.pending-products');
    Route::post('/admin/approve-product/{id}', [AdminController::class, 'approveProduct'])->name('admin.approve-product');
    Route::post('/admin/reject-product/{id}', [AdminController::class, 'rejectProduct'])->name('admin.reject-product');
});

// Owner Routes
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner/manage-products', [OwnerController::class, 'manageProducts'])->name('owner.manage-products');
    Route::post('/owner/create-product', [OwnerController::class, 'storeProduct'])->name('owner.store-product');
});

// Renter Routes
Route::middleware(['auth', 'role:Renter'])->group(function () {
    Route::get('/renter/product-feed', [RenterController::class, 'productFeed'])->name('renter.product-feed');
    Route::get('/renter/product-info/{id}', [RenterController::class, 'productInfo'])->name('renter.product-info');
});

Route::get('/renter/product-feed', [RenterController::class, 'productFeed'])
    ->middleware(['auth', 'role:Renter'])
    ->name('renter.product-feed');

Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(['prefix' => 'notifications', 'middleware' => ['auth']], function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

/**
 * Payment Routes
 */
Route::group(['prefix' => 'payments', 'middleware' => ['auth', 'role:Renter']], function () {
    Route::get('/order/{order}/form', [PaymentController::class, 'showPaymentForm'])->name('payments.form');
    Route::post('/order/{order}/process', [PaymentController::class, 'processPayment'])->name('payments.process');
});

/**
 * Profile Routes
 */
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
});

/**
 * Messaging Routes
 */
Route::group(['prefix' => 'messages', 'middleware' => ['auth']], function () {
    Route::get('/', [MessagingController::class, 'index'])->name('messages.index');
    Route::get('/{user}/show', [MessagingController::class, 'show'])->name('messages.show');
    Route::post('/{user}/send', [MessagingController::class, 'send'])->name('messages.send');
});
// Authentication Routes (Handled by Breeze or Laravel UI)
require __DIR__.'/auth.php';

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/pending-products', [AdminController::class, 'pendingProducts'])
        ->name('admin.pending-products');
        
    Route::post('/approve-product/{id}', [AdminController::class, 'approveProduct'])
        ->name('admin.approve-product');
        
    Route::post('/reject-product/{id}', [AdminController::class, 'rejectProduct'])
        ->name('admin.reject-product');

    // Add more admin routes here
});

// Owner Routes
Route::group(['prefix' => 'owner', 'middleware' => ['auth', 'role:Owner']], function () {
    Route::get('/create-product', [OwnerController::class, 'createProduct'])
        ->name('owner.create-product');
    Route::post('/create-product', [OwnerController::class, 'storeProduct'])
        ->name('owner.store-product');
    Route::get('/manage-products', [OwnerController::class, 'manageProducts'])
        ->name('owner.manage-products');
    // Add more owner routes here
});

// Renter Routes
Route::group(['prefix' => 'renter', 'middleware' => ['auth', 'role:Renter']], function () {
    Route::get('/product-feed', [RenterController::class, 'productFeed'])
        ->name('renter.product-feed');
    Route::get('/product-info/{id}', [RenterController::class, 'productInfo'])
        ->name('renter.product-info');
    
    // Cart Routes
    Route::group(['prefix' => 'cart'], function () {
        Route::get('/view', [RenterController::class, 'viewCart'])
            ->name('renter.cart.view');
        Route::post('/add/{product}', [RenterController::class, 'addToCart'])
            ->name('renter.cart.add');
        Route::delete('/remove/{item}', [RenterController::class, 'removeFromCart'])
            ->name('renter.cart.remove');
    });

    // Checkout Routes
    Route::get('/checkout', [RenterController::class, 'checkout'])
        ->name('renter.checkout');
    Route::post('/checkout/process', [RenterController::class, 'processCheckout'])
        ->name('renter.checkout.process');

    Route::get('/payment', [RenterController::class, 'payment'])
        ->name('renter.payment');
    
    // Rental Period Routes
    Route::group(['prefix' => 'rental'], function () {
        Route::get('/confirm-rent/{order}', [RenterController::class, 'confirmRent'])
            ->name('renter.rental.confirm-rent');
        Route::post('/daily-update/{order}', [RenterController::class, 'submitDailyUpdate'])
            ->name('renter.rental.daily-update');
        Route::get('/upload-proof/{order}', [RenterController::class, 'uploadProof'])
            ->name('renter.rental.upload-proof');
        Route::get('/rent-started/{order}', [RenterController::class, 'rentStarted'])
            ->name('renter.rental.rent-started');
        Route::get('/device-exchange/{order}', [RenterController::class, 'deviceExchange'])
            ->name('renter.rental.device-exchange');
    });

    // Review Routes
    Route::group(['prefix' => 'reviews'], function () {
        Route::get('/create/{order}', [RenterController::class, 'createReview'])
            ->name('renter.reviews.create');
        Route::post('/store/{order}', [RenterController::class, 'storeReview'])
            ->name('renter.reviews.store');

    
    });
    
});