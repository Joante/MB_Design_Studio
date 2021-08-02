<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PaintCollectionController;
use App\Http\Controllers\PaintController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Guest routes
 */

//Projects routes
Route::prefix('projects')->middleware('auth')->group(function () {
    Route::get('/list', [ProjectsController::class, 'index_admin'])->name('projects_index_admin');
    Route::get('/show/{id}/admin/{message?}', [ProjectsController::class, 'show_admin'])->name('projects_show_admin');
    Route::get('/edit/{id}', [ProjectsController::class, 'edit'])->name('projects_edit');
    Route::get('/create', [ProjectsController::class, 'create'])->name('projects_create');
    Route::post('/store', [ProjectsController::class, 'store'])->name('projects_store');
    Route::post('/update/{id}', [ProjectsController::class, 'update'])->name('projects_update');
    Route::post('/destroy', [ProjectsController::class, 'destroy'])->name('projects_destroy');    
});

Route::get('/', [InfoController::class, 'index'])->name('home');
Route::get('/about', [InfoController::class, 'about'])->name('about');
Route::get('/contact', [InfoController::class, 'contact'])->name('contact');
Route::post('/contact', [InfoController::class, 'storeContact'])->name('contact-send');

//Services routes
Route::prefix('services')->group(function () {
    Route::get('/', [ServicesController::class, 'index'])->name('services_index');
    Route::get('/services/{id}', [ServicesController::class, 'show'])->name('services_view');
});


//Projects routes
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects_index');
    Route::get('/{id}', [ProjectsController::class, 'show'])->name('projects_view');
    Route::get('/category/{category_id}', [ProjectsController::class, 'show_category'])->name('project_view_category');
});


//Blog routes
Route::prefix('blog')->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog_index');
    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog_view');
    Route::get('/blog/list/{category_id}', [BlogController::class, 'show_category'])->name('blog_view_category');
});


//Art routes
Route::prefix('art')->group(function () {
    Route::get('/', [ArtController::class, 'index'])->name('art_index');

    //Paint routes
    Route::prefix('paint')->group(function () {
        Route::get('/', [PaintController::class, 'index'])->name('paint_index');
        Route::get('/{id}', [PaintController::class, 'show'])->name('paint_show');
        Route::get('/{idCategory}/list', [PaintCollectionController::class, 'index'])->name('paint_collection_index');
    });
    
    //Exhibition routes
    Route::prefix('exhibition')->group(function () {
        Route::get('/', [ExhibitionController::class, 'index'])->name('exhibition_index');
        Route::get('/{id}', [ExhibitionController::class, 'show'])->name('exhibition_show');
    });
});

/**
 * Admin Routes
 */
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class,'index'])->name('admin');
    Route::get('/settings', [AdminController::class, 'edit'])->name('admin_edit');
    Route::post('/update', [AdminController::class, 'update'])->name('admin_update');
    Route::post('/avatar/update', [AdminController::class, 'avatar_update'])->name('avatar_update');
    Route::post('/change_password', [AdminController::class, 'change_password'])->name('change_password');
    Route::post('/update_socials', [AdminController::class, 'update_socials'])->name('update_socials');
});


//Services routes
Route::prefix('services')->middleware('auth')->group(function () {
    Route::get('/list', [ServicesController::class, 'index_admin'])->name('services_index_admin');
    Route::get('/show/{id}/admin/{message?}', [ServicesController::class, 'show_admin'])->name('services_show_admin');
    Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('services_edit');
    Route::get('/create', [ServicesController::class, 'create'])->name('services_create');
    Route::post('/store', [ServicesController::class, 'store'])->name('services_store');
    Route::post('/update/{id}', [ServicesController::class, 'update'])->name('services_update');
    Route::post('/destroy', [ServicesController::class, 'destroy'])->name('services_destroy');
});



//Blog routes
Route::prefix('blog')->middleware('auth')->group(function () {
    Route::get('/list', [BlogController::class, 'index_admin'])->name('blog_index_admin');
    Route::get('/show/{id}/admin/{message?}', [BlogController::class, 'show_admin'])->name('blog_show_admin');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog_edit');
    Route::get('/create', [BlogController::class, 'create'])->name('blog_create');
    Route::post('/store', [BlogController::class, 'store'])->name('blog_store');
    Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog_update');
    Route::post('/destroy', [BlogController::class, 'destroy'])->name('blog_destroy');
    
    //Blog Categories routes
    Route::prefix('category')->group(function (){
        Route::get('/list', [BlogCategoriesController::class, 'index'])->name('blog_categories_index');
        Route::get('/show/{id}/{message?}', [BlogCategoriesController::class, 'show'])->name('blog_category_show');
        Route::get('/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('blog_category_edit');
        Route::get('/create', [BlogCategoriesController::class, 'create'])->name('blog_category_create');
        Route::post('/store', [BlogCategoriesController::class, 'store'])->name('blog_category_store');
        Route::post('/update/{id}', [BlogCategoriesController::class, 'update'])->name('blog_category_update');
        Route::post('/destroy', [BlogCategoriesController::class, 'destroy'])->name('blog_category_destroy');
    });
});

//Art routes
Route::prefix('art')->middleware('auth')->group(function () {
    Route::get('/admin', [ArtController::class, 'index_admin'])->name('art_index_admin');

    //Paint routes
    Route::prefix('paint')->group(function () {
        Route::get('/show/{id}/{message?}', [PaintController::class, 'show_admin'])->name('paint_show_admin');
        Route::get('/edit/{id}', [PaintController::class, 'edit'])->name('paint_edit');
        Route::get('/create', [PaintController::class, 'create'])->name('paint_create');
        Route::post('/store', [PaintController::class, 'store'])->name('paint_store');
        Route::post('/update/{id}', [PaintController::class, 'update'])->name('paint_update');
        Route::post('/destroy', [PaintController::class, 'destroy'])->name('paint_destroy');
        Route::get('/{idCategory}/list/admin', [PaintCollectionController::class, 'index_admin'])->name('paint_collection_index_admin');
        Route::prefix('collection')->group(function () {
            Route::get('/{idCategory}/create', [PaintCollectionController::class, 'create'])->name('paint_collection_create');
            Route::post('/{idCategory}/store', [PaintCollectionController::class, 'store'])->name('paint_collection_store');
            Route::get('/{idCategory}/edit', [PaintCollectionController::class, 'edit'])->name('paint_collection_edit');
            Route::post('/{idCategory}/update', [PaintCollectionController::class, 'update'])->name('paint_collection_update');
            Route::post('/{idCategory}/destroy', [PaintCollectionController::class, 'destroy'])->name('paint_collection_destroy');
        });
    });

    //Exhibition routes
    Route::prefix('exhibition')->group(function () {
        Route::get('/show/{id}/{message?}', [ExhibitionController::class, 'show_admin'])->name('exhibition_show_admin');
        Route::get('/edit/{id}', [ExhibitionController::class, 'edit'])->name('exhibition_edit');
        Route::get('/create', [ExhibitionController::class, 'create'])->name('exhibition_create');
        Route::post('/store', [ExhibitionController::class, 'store'])->name('exhibition_store');
        Route::post('/update/{id}', [ExhibitionController::class, 'update'])->name('exhibition_update');
        Route::post('/destroy', [ExhibitionController::class, 'destroy'])->name('exhibition_destroy');
    });
});

//Images routes
Route::prefix('images')->middleware('auth')->group(function () {
    Route::get('/upload/{modelType}/{modelId}', [ImagesController::class, 'create'])->name('images_create_model');
    Route::post('/store/{modelType}/{modelId}', [ImagesController::class, 'store'])->name('images_store');
    Route::get('/edit/{modelType}/{modelId}', [ImagesController::class, 'edit'])->name('images_edit');
    Route::post('/delete/{modelType}/{modelId}', [ImagesController::class, 'delete'])->name('images_delete');
});




require __DIR__.'/auth.php';
