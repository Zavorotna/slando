<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\ExchangeRate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SubsubcategoryController;


Route::get('/', function () {
    return view('auth.login');
});
Route::get('/admin', function () {
    return to_route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//роут який повертає сторінку по заданому URI
// Route::get('/index', function() {
    //     return view('index');
    // });

/* =================================== */
/*             Admin panel             */
/* =================================== */

Route::middleware(Admin::class)->group(function () {  
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('category.index');
            Route::get('/category/create', 'create')->name('category.create');
            Route::post('/category/store', 'store')->name('category.store');
            Route::get('/category/edit/{id}', 'edit')->name('category.edit');
            Route::patch('/category/update/{id}', 'update')->name('category.update');
            Route::delete('/category/destroy/{id}', 'destroy')->name('category.destroy');
        });

        Route::controller(SubcategoryController::class)->group(function() {
            Route::get('/subcategories', 'index')->name('subcategory.index');
            Route::get('/subcategory/create', 'create')->name('subcategory.create');
            Route::post('/subcategory/store', 'store')->name('subcategory.store');
            Route::get('/subcategory/edit/{id}', 'edit')->name('subcategory.edit');
            Route::patch('/subcategory/update/{id}', 'update')->name('subcategory.update');
            Route::delete('/subcategory/destroy/{id}', 'destroy')->name('subcategory.destroy');
        });
        
        Route::controller(SubsubcategoryController::class)->group(function() {
            Route::get('/subsubcategories', 'index')->name('subsubcategory.index');
            Route::get('/subsubcategory/create', 'create')->name('subsubcategory.create');
            Route::post('/subsubcategory/store', 'store')->name('subsubcategory.store');
            Route::get('/subsubcategory/edit/{id}', 'edit')->name('subsubcategory.edit');
            Route::patch('/subsubcategory/update/{id}', 'update')->name('subsubcategory.update');
            Route::delete('/subsubcategory/destroy/{id}', 'destroy')->name('subsubcategory.destroy');
        });
            
        Route::controller(ProductsController::class)->group(function() {
            Route::get('/products', 'index')->name('products.index');
            Route::delete('/products/destroy/{id}', 'destroy')->name('products.destroy');
        });
            
        Route::patch('/rates/update', [RateController::class, 'update'])->name('rates.update');
    });
});
/* =================================== */
/*             User panel             */
/* =================================== */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/user')->name('user.')->group(function () {
        Route::controller(UserProductController::class)->group(function() {
            Route::get('/products', 'index')->name('products.index');
            Route::get('/products/create', 'create')->name('products.create');
            Route::post('/products/store', 'store')->name('products.store');
            Route::get('/products/edit/{id}', 'edit')->name('products.edit');
            Route::patch('/products/update/{product}', 'update')->name('products.update');
            Route::patch('/products/restore/{id}', 'restore')->name('products.restore');
            Route::delete('/products/destroy/{product}', 'destroy')->name('products.destroy');
        });
        Route::controller(UserProductController::class)->group(function() { //поміняти на нормальний роут на профіль користувача
            Route::get('/products', 'index')->name('products.index');
        });
    });
});
// });
require __DIR__.'/auth.php';
