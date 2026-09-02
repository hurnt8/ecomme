<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\OrderPdfController;
use App\Http\Controllers\Shop\OrderTrackingController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/boutique', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produit/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::patch('/{key}', [CartController::class, 'update'])->name('update');
    Route::delete('/{key}', [CartController::class, 'destroy'])->name('destroy');
});

Route::prefix('commande')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/confirmation', [CheckoutController::class, 'confirmation'])->name('confirmation');
});

// Signed links (emailed to the customer / shown on the confirmation page).
// No login required: the signature itself authorizes the download.
Route::middleware('signed')->group(function () {
    Route::get('/commande/{order:order_number}/facture', [OrderPdfController::class, 'invoice'])->name('orders.invoice');
    Route::get('/commande/{order:order_number}/recu', [OrderPdfController::class, 'receipt'])->name('orders.receipt');
});

Route::prefix('suivi')->name('tracking.')->group(function () {
    Route::get('/', [OrderTrackingController::class, 'index'])->name('index');
    Route::post('/', [OrderTrackingController::class, 'search'])
        ->middleware('throttle:5,1')
        ->name('search');
});

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/connexion', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');
});

Route::post('/deconnexion', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));
