<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AppBannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrentDealsController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\SpotlightController;
use App\Http\Controllers\SubCatController;
use App\Http\Controllers\SuperSaveDealsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;



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


    Route::get('/banners/create', [AppBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners/store', [AppBannerController::class, 'store'])->name('banners.store');
    Route::resource('banners', AppBannerController::class);


    Route::get('create/promocode', [PromocodeController::class, 'create'])->name('promocode.create');
    Route::post('/promocode/store', [PromocodeController::class, 'store'])->name('promocode.store');
    Route::get('/promocode/{id}/edit', [PromocodeController::class, 'edit'])->name('promocode.edit');
    Route::put('/promocode/{id}', [PromocodeController::class, 'update'])->name('promocode.update');
    Route::delete('/promocode/{id}', [PromocodeController::class, 'destroy'])->name('promocode.destroy');


    Route::get('/vendor/view', [VendorController::class, 'view'])->name('vendor.view');

    Route::get('/user/view', [UsersController::class, 'view'])->name('user.view');


    Route::get('/user/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UsersController::class, 'delete'])->name('user.delete');
    Route::post('/user/update-status', [UsersController::class, 'updateStatus'])->name('user.updateStatus');


    Route::get('/vendor/view', [VendorController::class, 'view'])->name('vendor.view');
    Route::get('/vendor/edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::post('/vendor/update/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/delete/{id}', [VendorController::class, 'destroy'])->name('vendor.delete');
    Route::post('/vendor/update-status', [VendorController::class, 'updateStatus'])->name('vendor.updateStatus');

    Route::get('/create/spotlight', [SpotlightController::class, 'index'])->name('spotlight.create');
    Route::post('/store/spotlight', [SpotlightController::class, 'store'])->name('spotlight.store');
    Route::get('/edit/{id}/spotlight', [SpotlightController::class, 'edit'])->name('spotlight.edit');
    Route::put('/update/{id}/spotlight', [SpotlightController::class, 'update'])->name('spotlight.update');
    Route::delete('/delete/{id}/spotlight', [SpotlightController::class, 'destroy'])->name('spotlight.destroy');

    Route::get('/create/designer', [DesignerController::class, 'index'])->name('designer.create');
    Route::post('/store/designer', [DesignerController::class, 'store'])->name('designer.store');
    Route::get('/edit/{id}/designer', [DesignerController::class, 'edit'])->name('designer.edit');
    Route::put('/update/{id}/designer', [DesignerController::class, 'update'])->name('designer.update');
    Route::delete('/delete/{id}/designer', [DesignerController::class, 'delete'])->name('designer.delete');

    Route::get('/create/currentdeals', [CurrentDealsController::class, 'index'])->name('currentdeals.create');
    Route::post('/store/currentdeals', [CurrentDealsController::class, 'store'])->name('currentdeals.store');
    Route::get('/edit/currentdeals/{id}', [CurrentDealsController::class, 'edit'])->name('currentdeals.edit');
    Route::put('/update/currentdeals/{id}', [CurrentDealsController::class, 'update'])->name('currentdeals.update');
    Route::delete('/delete/currentdeals/{id}', [CurrentDealsController::class, 'delete'])->name('currentdeals.delete');

    Route::get('/create/supersaverdeals', [SuperSaveDealsController::class, 'index'])->name('supersaverdeals.create');
    Route::post('/store/supersaverdeals', [SuperSaveDealsController::class, 'store'])->name('supersaverdeals.store');
    Route::get('/edit/supersaverdeals/{id}', [SuperSaveDealsController::class, 'edit'])->name('supersaverdeals.edit');
    Route::put('/update/supersaverdeals/{id}', [SuperSaveDealsController::class, 'update'])->name('supersaverdeals.update');
    Route::delete('/delete/supersaverdeals/{id}', [SuperSaveDealsController::class, 'delete'])->name('supersaverdeals.delete');



});
