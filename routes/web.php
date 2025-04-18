<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SubsubcategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//роут який повертає сторінку по заданому URI
// Route::get('/index', function() {
    //     return view('index');
    // });
Route::name('admin.')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('category.index');
        Route::get('/category/create', 'create')->name('category.create');
        Route::post('/category/store', 'store')->name('category.store');
        Route::get('/category/edit/{id}', 'edit')->name('category.edit');
        Route::patch('/category/update/{id}', 'update')->name('category.update');
        Route::delete('/category/destroy/{id}', 'destroy')->name('category.destroy');
    });
    
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategory.index');
    Route::get('/subcategory/create', [SubcategoryController::class, 'create'])->name('subcategory.create');
    Route::post('/subcategory/store', [SubcategoryController::class, 'store'])->name('subcategory.store');
    Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
    Route::patch('/subcategory/update/{id}', [SubcategoryController::class, 'update'])->name('subcategory.update');
    Route::delete('/subcategory/destroy/{id}', [SubcategoryController::class, 'destroy'])->name('subcategory.destroy');

    Route::get('/subsubcategories', [SubsubcategoryController::class, 'index'])->name('subsubcategory.index');
    Route::get('/subsubcategory/create', [SubsubcategoryController::class, 'create'])->name('subsubcategory.create');
    Route::post('/subsubcategory/store', [SubsubcategoryController::class, 'store'])->name('subsubcategory.store');
    Route::get('/subsubcategory/edit/{id}', [SubsubcategoryController::class, 'edit'])->name('subsubcategory.edit');
    Route::patch('/subsubcategory/update/{id}', [SubsubcategoryController::class, 'update'])->name('subsubcategory.update');
    Route::delete('/subsubcategory/destroy/{id}', [SubsubcategoryController::class, 'destroy'])->name('subsubcategory.destroy');

});

require __DIR__.'/auth.php';
