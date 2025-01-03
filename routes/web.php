<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCatController;
use App\Http\Controllers\VendorController;

// Admin login routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('index');
    });

    Route::get('/admin/settings', function () {
        return view('admin.settings');
    });

    Route::get('/add/category', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');  // Updated to PUT method for updating
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');  // Updated to DELETE for destroy


   // Add the following to your routes file, for example `routes/web.php`:

// Display the form for adding a new subcategory
Route::get('/add/subcategory', [SubCatController::class, 'index'])->name('subcategories.index');

// Store the new subcategory
Route::post('/subcategories', [SubCatController::class, 'store'])->name('subcategories.store'); // This is the route for storing subcategories

// Edit a subcategory
Route::get('/subcategories/{subcategory}/edit', [SubCatController::class, 'edit'])->name('subcategories.edit');

// Update a subcategory
Route::put('/subcategories/{subcategory}', [SubCatController::class, 'update'])->name('subcategories.update');

// Soft delete a subcategory
Route::delete('/subcategories/{subcategory}', [SubCatController::class, 'destroy'])->name('subcategories.destroy');

});
