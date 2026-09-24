<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
 * The group is already behind `auth` + `staff` (see routes/web.php), so a supervisor is inside.
 * Everything a supervisor must not reach carries `admin` on top of that — the deny is on the
 * route, not on a hidden menu entry, so typing the URL by hand is refused too.
 */

/*
 * The dashboard reports revenue, average order value and a 14-day sales chart, which is more
 * than a supervisor's remit — so /admin lands them on the orders list instead of on the takings.
 * Handled here rather than inside the controller: the redirect happens before any figure is
 * queried, so there is nothing to leak by accident.
 */
Route::get('/', function () {
    if (request()->user()->isSupervisor()) {
        return redirect()->route('admin.commandes.index');
    }

    return app(DashboardController::class)->index();
})->name('dashboard');

// Orders: the supervisor's whole remit — list, detail, and moving the status along.
Route::get('commandes', [OrderController::class, 'index'])->name('commandes.index');
Route::get('commandes/{order}', [OrderController::class, 'show'])->name('commandes.show');
Route::patch('commandes/{order}', [OrderController::class, 'update'])->name('commandes.update');

Route::middleware('admin')->group(function () {
    Route::resource('produits', ProductController::class)
        ->parameters(['produits' => 'product'])
        ->except(['show']);
    Route::delete('produits/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('produits.images.destroy');
    Route::patch('produits/{product}/images/{image}/principale', [ProductController::class, 'setMainImage'])->name('produits.images.main');

    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::resource('bannieres', BannerController::class)
        ->parameters(['bannieres' => 'banner'])
        ->except(['show']);

    Route::resource('utilisateurs', UserController::class)
        ->parameters(['utilisateurs' => 'user'])
        ->except(['show']);

    Route::get('reglages', [SettingController::class, 'edit'])->name('reglages.edit');
    Route::patch('reglages', [SettingController::class, 'update'])->name('reglages.update');
});
