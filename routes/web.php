<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtColectionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\HomepageImagesController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LocationController;
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
    Route::get('/show/{id}/admin', [ProjectsController::class, 'show_admin'])->name('projects_show_admin');
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
    Route::get('/{id}', [ServicesController::class, 'show'])->name('services_view');
});


//Projects routes
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects_index');
    Route::get('/{id}', [ProjectsController::class, 'show'])->name('projects_view');
});


//Blog routes
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog_index');
    Route::get('/{id}', [BlogController::class, 'show'])->name('blog_view');
});


//Art routes
Route::prefix('art')->group(function () {
    Route::get('/', [ArtController::class, 'index'])->name('art_index');

    //Paint routes
    Route::prefix('paint')->group(function () {
        Route::get('/', [PaintController::class, 'index'])->name('paint_index');
        Route::get('/{id}', [PaintController::class, 'show'])->name('paint_show');
        Route::get('/{idCategory}', [PaintController::class, 'show_colection'])->name('paint_collection_index');
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
    Route::post('/update_about', [InfoController::class, 'update_about'])->name('update_about');
    Route::post('/update_degree/{id}', [AdminController::class, 'update_degree'])->name('update_degree');
    Route::post('/store_degree', [AdminController::class, 'store_degree'])->name('store_degree');
    Route::post('/degrees/destroy', [AdminController::class, 'destroy_degree'])->name('destroy_degree');

});

//Homepage Images routes
Route::prefix('homepage_images')->middleware('auth')->group(function (){
    Route::get('/list', [HomepageImagesController::class, 'index'])->name('homepage_images_index');
    Route::get('/show/{id}', [HomepageImagesController::class, 'show'])->name('homepage_images_show');
    Route::get('/edit/{id}', [HomepageImagesController::class, 'edit'])->name('homepage_images_edit');
    Route::get('/create', [HomepageImagesController::class, 'create'])->name('homepage_images_create');
    Route::post('/store', [HomepageImagesController::class, 'store'])->name('homepage_images_store');
    Route::post('/update/{id}', [HomepageImagesController::class, 'update'])->name('homepage_images_update');
    Route::post('/destroy', [HomepageImagesController::class, 'destroy'])->name('homepage_images_destroy');
});

//Services routes
Route::prefix('services')->middleware('auth')->group(function () {
    Route::get('/list', [ServicesController::class, 'index_admin'])->name('services_index_admin');
    Route::get('/show/{id}/admin', [ServicesController::class, 'show_admin'])->name('services_show_admin');
    Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('services_edit');
    Route::get('/create', [ServicesController::class, 'create'])->name('services_create');
    Route::post('/store', [ServicesController::class, 'store'])->name('services_store');
    Route::post('/update/{id}', [ServicesController::class, 'update'])->name('services_update');
    Route::post('/destroy', [ServicesController::class, 'destroy'])->name('services_destroy');
});



//Blog routes
Route::prefix('blog')->middleware('auth')->group(function () {
    Route::get('/list', [BlogController::class, 'index_admin'])->name('blog_index_admin');
    Route::get('/show/{id}/admin', [BlogController::class, 'show_admin'])->name('blog_show_admin');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog_edit');
    Route::get('/create', [BlogController::class, 'create'])->name('blog_create');
    Route::post('/store', [BlogController::class, 'store'])->name('blog_store');
    Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog_update');
    Route::post('/destroy', [BlogController::class, 'destroy'])->name('blog_destroy');
});

//Art routes
Route::prefix('art')->middleware('auth')->group(function () {
    //Paint routes
    Route::prefix('painting')->group(function () {
        Route::get('/list/admin', [PaintController::class, 'index_admin'])->name('paint_index_admin');
        Route::get('/show/{id}', [PaintController::class, 'show_admin'])->name('paint_show_admin');
        Route::get('/edit/{id}', [PaintController::class, 'edit'])->name('paint_edit');
        Route::get('/create', [PaintController::class, 'create'])->name('paint_create');
        Route::post('/store', [PaintController::class, 'store'])->name('paint_store');
        Route::post('/update/{id}', [PaintController::class, 'update'])->name('paint_update');
        Route::post('/destroy', [PaintController::class, 'destroy'])->name('paint_destroy');
        Route::get('/{idColection}/admin', [ArtColectionsController::class, 'show_paints_admin'])->name('paint_colection_admin');
        Route::prefix('colection')->group(function () {
            Route::get('/list/admin', [ArtColectionsController::class, 'index_admin'])->name('paint_colection_index_admin');
            Route::get('show/admin/{id}', [ArtColectionsController::class, 'show_admin'])->name('paint_colection_show_admin');
            Route::get('/create', [ArtColectionsController::class, 'create'])->name('paint_colection_create');
            Route::post('/store', [ArtColectionsController::class, 'store'])->name('paint_colection_store');
            Route::get('/edit/{id}', [ArtColectionsController::class, 'edit'])->name('paint_colection_edit');
            Route::post('/update/{id}', [ArtColectionsController::class, 'update'])->name('paint_colection_update');
            Route::post('/destroy', [ArtColectionsController::class, 'destroy'])->name('paint_colection_destroy');
        });
    });

    //Exhibition routes
    Route::prefix('exhibition')->group(function () {
        Route::get('/list/admin', [ExhibitionController::class, 'index_admin'])->name('exhibitions_index_admin');
        Route::get('/show/{id}', [ExhibitionController::class, 'show_admin'])->name('exhibition_show_admin');
        Route::get('/edit/{id}', [ExhibitionController::class, 'edit'])->name('exhibition_edit');
        Route::get('/create/new', [ExhibitionController::class, 'create'])->name('exhibition_create');
        Route::post('/store', [ExhibitionController::class, 'store'])->name('exhibition_store');
        Route::post('/update/{id}', [ExhibitionController::class, 'update'])->name('exhibition_update');
        Route::post('/destroy', [ExhibitionController::class, 'destroy'])->name('exhibition_destroy');
        Route::prefix('locations')->group(function () {
            Route::get('/list', [LocationController::class, 'index'])->name('location_index');
            Route::get('/show/{id}', [LocationController::class, 'show'])->name('location_show');
            Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location_edit');
            Route::get('/create', [LocationController::class, 'create'])->name('location_create');
            Route::post('/store', [LocationController::class, 'store'])->name('location_store');
            Route::post('/update/{id}', [LocationController::class, 'update'])->name('location_update');
            Route::post('/destroy', [LocationController::class, 'destroy'])->name('location_destroy');
        });
    });
});

//Images routes
Route::prefix('images')->middleware('auth')->group(function () {
    Route::get('/upload/{modelType}/{modelId}', [ImagesController::class, 'create'])->name('images_create_model');
    Route::post('/store/{modelType}/{modelId}', [ImagesController::class, 'store'])->name('images_store');
    Route::get('/edit/{modelType}/{modelId}', [ImagesController::class, 'edit'])->name('images_edit');
    Route::post('/delete/{modelType}/{modelId}', [ImagesController::class, 'delete'])->name('images_delete');
    Route::post('/update/{modelType}/{modelId}', [ImagesController::class,'updateImageWithHierarchy'])->name('images_update');
});




require __DIR__.'/auth.php';
