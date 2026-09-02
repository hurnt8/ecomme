<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('produits', ProductController::class)
    ->parameters(['produits' => 'product'])
    ->except(['show']);
Route::delete('produits/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('produits.images.destroy');
Route::patch('produits/{product}/images/{image}/principale', [ProductController::class, 'setMainImage'])->name('produits.images.main');

Route::resource('categories', CategoryController::class)->except(['show']);

Route::resource('bannieres', BannerController::class)
    ->parameters(['bannieres' => 'banner'])
    ->except(['show']);

Route::get('commandes', [OrderController::class, 'index'])->name('commandes.index');
Route::get('commandes/{order}', [OrderController::class, 'show'])->name('commandes.show');
Route::patch('commandes/{order}', [OrderController::class, 'update'])->name('commandes.update');

Route::get('reglages', [SettingController::class, 'edit'])->name('reglages.edit');
Route::patch('reglages', [SettingController::class, 'update'])->name('reglages.update');
