<?php

use App\Http\Middleware\User;
use App\Http\Middleware\Admin;
use App\Http\Middleware\ExchangeRate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Controllers\Site\LangController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SubsubcategoryController;
use App\Http\Controllers\Site\ProductController as SiteProductController;
use App\Http\Controllers\User\ProductController as UserProductController;

// Route::get('/', function () {
//     return view('auth.login');
// });
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

        Route::controller(ColorController::class)->group(function() {
            Route::get('/color', 'index')->name('color.index');
            Route::get('/color/create', 'create')->name('color.create');
            Route::post('/color/store', 'store')->name('color.store');
            Route::get('/color/edit/{id}', 'edit')->name('color.edit');
            Route::patch('/color/update/{color}', 'update')->name('color.update');
            Route::patch('/color/restore/{id}', 'restore')->name('color.restore');
            Route::delete('/color/destroy/{color}', 'destroy')->name('color.destroy');
        });
        Route::controller(SizeController::class)->group(function() {
            Route::get('/size', 'index')->name('size.index');
            Route::get('/size/create', 'create')->name('size.create');
            Route::post('/size/store', 'store')->name('size.store');
            Route::get('/size/edit/{id}', 'edit')->name('size.edit');
            Route::patch('/size/update/{size}', 'update')->name('size.update');
            Route::patch('/size/restore/{id}', 'restore')->name('size.restore');
            Route::delete('/size/destroy/{size}', 'destroy')->name('size.destroy');
        });
    });
});

/* =================================== */
/*             User panel             */
/* =================================== */
Route::middleware(['auth', User::class])->group(function () {
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
        
        Route::controller(ReviewController::class)->group(function() {
            Route::post('/review/store', 'store')->name('reviews.store');
            Route::get('/review/edit/{id}', 'edit{id}')->name('reviews.edit');
            Route::patch('/review/update/{id}', 'update')->name('reviews.update');
            Route::delete('/review/destroy/{id}', 'destroy')->name('reviews.destroy');
        });
    });
    
    Route::middleware([SetLocaleMiddleware::class])->group(function() {
        Route::get('/likedPage', [SiteProductController::class, 'likedPage'])->name('site.likedPage');
        Route::post('/liked', [SiteProductController::class, 'liked'])->name('site.liked');
        Route::delete('/removeLiked', [SiteProductController::class, 'removeLiked'])->name('site.removeLiked');
    });

});

/* =================================== */
/*             Site panel             */
/* =================================== */
Route::get('/locale/{locale}', [LangController::class, 'switch'])->name('setLocale');
Route::middleware([SetLocaleMiddleware::class])->group(function() {
    Route::controller(SiteProductController::class)->group(function() {
        Route::get('/', 'index')->name('site.index');
        Route::get('/catalogue', 'catalogue')->name('site.catalogue');
        Route::get('/product/{id}', 'product')->name('site.product');
    });
});


require __DIR__.'/auth.php';
