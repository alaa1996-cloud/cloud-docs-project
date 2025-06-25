<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['auth', 'verified'])->group(function () {

    // لوحة التحكم الافتراضية تعرض المستندات
    Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');

    // البحث والتصفية (AJAX)
    Route::get('/documents/search', [DocumentController::class, 'search'])->name('documents.search');

    // CRUD المستندات مع تقييد الحذف فقط للمشرف
    Route::resource('documents', DocumentController::class)->except(['destroy']);
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->middleware('admin')->name('documents.destroy');

    // إدارة الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // إدارة التصنيفات والكلمات المفتاحية للمشرف فقط
    Route::middleware('admin')->group(function () {
        Route::resource('categories', CategoryController::class);

        Route::get('/categories/{category}/keywords', [KeywordController::class, 'index'])->name('keywords.index');
        Route::get('/categories/{category}/keywords/create', [KeywordController::class, 'create'])->name('keywords.create');
        Route::post('/categories/{category}/keywords', [KeywordController::class, 'store'])->name('keywords.store');
        Route::get('/keywords/{keyword}/edit', [KeywordController::class, 'edit'])->name('keywords.edit');
        Route::put('/keywords/{keyword}', [KeywordController::class, 'update'])->name('keywords.update');
        Route::delete('/keywords/{keyword}', [KeywordController::class, 'destroy'])->name('keywords.destroy');
    });
    Route::get('/clear-cache', function() {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('config:cache');
        return 'Cache cleared!';
    });

});

require __DIR__.'/auth.php';
