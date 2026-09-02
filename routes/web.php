<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Shop\AccountController;
use App\Http\Controllers\Shop\BlogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\ContactController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\NewsletterController;
use App\Http\Controllers\Shop\OrderPdfController;
use App\Http\Controllers\Shop\OrderTrackingController;
use App\Http\Controllers\Shop\PageController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

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
    Route::post('/', [CheckoutController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('store');
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

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('newsletter.store');

Route::get('/a-propos', [PageController::class, 'about'])->name('pages.about');
Route::get('/carrieres', [PageController::class, 'careers'])->name('pages.careers');
Route::get('/presse', [PageController::class, 'press'])->name('pages.press');
Route::get('/aide', [PageController::class, 'help'])->name('pages.help');
Route::get('/mentions-legales', [PageController::class, 'legalNotice'])->name('pages.legal-notice');
Route::get('/confidentialite', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/cookies', [PageController::class, 'cookies'])->name('pages.cookies');
Route::get('/accessibilite', [PageController::class, 'accessibility'])->name('pages.accessibility');
Route::get('/livraison', [PageController::class, 'shipping'])->name('pages.shipping');
Route::get('/retours', [PageController::class, 'returns'])->name('pages.returns');
Route::get('/moyens-paiement', [PageController::class, 'paymentMethods'])->name('pages.payment-methods');
Route::get('/cgv', [PageController::class, 'terms'])->name('pages.terms');

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/connexion', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::get('/inscription', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:5,1');
});

Route::post('/deconnexion', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('mon-compte')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/profil', [AccountController::class, 'editProfile'])->name('profile');
    Route::put('/profil', [AccountController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));
