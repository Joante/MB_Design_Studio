<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChartsController;
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

// Main Page Route
// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('verified');
Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce');

/* Route Dashboards */
Route::group(['prefix' => 'dashboard'], function () {
  Route::get('analytics', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics');
  //Route::get('ecommerce', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce');
});
/* Route Dashboards */

/* Route Apps */
Route::group(['prefix' => 'app'], function () {
  Route::get('email', [AppsController::class,'emailApp'])->name('app-email');
  Route::get('chat', [AppsController::class,'chatApp'])->name('app-chat');
  Route::get('todo', [AppsController::class,'todoApp'])->name('app-todo');
  Route::get('calendar', [AppsController::class,'calendarApp'])->name('app-calendar');
  Route::get('kanban', [AppsController::class,'kanbanApp'])->name('app-kanban');
  Route::get('invoice/list', [AppsController::class,'invoice_list'])->name('app-invoice-list');
  Route::get('invoice/preview', [AppsController::class,'invoice_preview'])->name('app-invoice-preview');
  Route::get('invoice/edit', [AppsController::class,'invoice_edit'])->name('app-invoice-edit');
  Route::get('invoice/add', [AppsController::class,'invoice_add'])->name('app-invoice-add');
  Route::get('invoice/print', [AppsController::class,'invoice_print'])->name('app-invoice-print');
  Route::get('ecommerce/shop', [AppsController::class,'ecommerce_shop'])->name('app-ecommerce-shop');
  Route::get('ecommerce/details', [AppsController::class,'ecommerce_details'])->name('app-ecommerce-details');
  Route::get('ecommerce/wishlist', [AppsController::class,'ecommerce_wishlist'])->name('app-ecommerce-wishlist');
  Route::get('ecommerce/checkout', [AppsController::class,'ecommerce_checkout'])->name('app-ecommerce-checkout');
  Route::get('file-manager', [AppsController::class,'file_manager'])->name('app-file-manager');
  Route::get('user/list', [AppsController::class,'user_list'])->name('app-user-list');
  Route::get('user/view', [AppsController::class,'user_view'])->name('app-user-view');
  Route::get('user/edit', [AppsController::class,'user_edit'])->name('app-user-edit');
});
/* Route Apps */

/* Route UI */
Route::group(['prefix' => 'ui'], function () {
  Route::get('typography', [UserInterfaceController::class,'typography'])->name('ui-typography');
  Route::get('colors', [UserInterfaceController::class,'colors'])->name('ui-colors');
});
/* Route UI */

/* Route Icons */
Route::group(['prefix' => 'icons'], function () {
  Route::get('feather', [UserInterfaceController::class,'icons_feather'])->name('icons-feather');
});
/* Route Icons */

/* Route Cards */
Route::group(['prefix' => 'card'], function () {
  Route::get('basic', [CardsController::class,'card_basic'])->name('card-basic');
  Route::get('advance', [CardsController::class,'card_advance'])->name('card-advance');
  Route::get('statistics', [CardsController::class,'card_statistics'])->name('card-statistics');
  Route::get('analytics', [CardsController::class,'card_analytics'])->name('card-analytics');
  Route::get('actions', [CardsController::class,'card_actions'])->name('card-actions');
});
/* Route Cards */

/* Route Components */
Route::group(['prefix' => 'component'], function () {
  Route::get('alert', [ComponentsController::class,'alert'])->name('component-alert');
  Route::get('avatar', [ComponentsController::class,'avatar'])->name('component-avatar');
  Route::get('badges', [ComponentsController::class,'badges'])->name('component-badges');
  Route::get('breadcrumbs', [ComponentsController::class,'breadcrumbs'])->name('component-breadcrumbs');
  Route::get('buttons', [ComponentsController::class,'buttons'])->name('component-buttons');
  Route::get('carousel', [ComponentsController::class,'carousel'])->name('component-carousel');
  Route::get('collapse', [ComponentsController::class,'collapse'])->name('component-collapse');
  Route::get('divider', [ComponentsController::class,'divider'])->name('component-divider');
  Route::get('dropdowns', [ComponentsController::class,'dropdowns'])->name('component-dropdowns');
  Route::get('list-group', [ComponentsController::class,'list_group'])->name('component-list-group');
  Route::get('modals', [ComponentsController::class,'modals'])->name('component-modals');
  Route::get('pagination', [ComponentsController::class,'pagination'])->name('component-pagination');
  Route::get('navs', [ComponentsController::class,'navs'])->name('component-navs');
  Route::get('tabs', [ComponentsController::class,'tabs'])->name('component-tabs');
  Route::get('timeline', [ComponentsController::class,'timeline'])->name('component-timeline');
  Route::get('pills', [ComponentsController::class,'pills'])->name('component-pills');
  Route::get('tooltips', [ComponentsController::class,'tooltips'])->name('component-tooltips');
  Route::get('popovers', [ComponentsController::class,'popovers'])->name('component-popovers');
  Route::get('pill-badges', [ComponentsController::class,'pill_badges'])->name('component-pill-badges');
  Route::get('progress', [ComponentsController::class,'progress'])->name('component-progress');
  Route::get('media-objects', [ComponentsController::class,'media_objects'])->name('component-media-objects');
  Route::get('spinner', [ComponentsController::class,'spinner'])->name('component-spinner');
  Route::get('toast', [ComponentsController::class,'toast'])->name('component-toast');
});
/* Route Components */

/* Route Extensions */
Route::group(['prefix' => 'ext-component'], function () {
  Route::get('sweet-alerts', [ExtensionController::class,'sweet_alert'])->name('ext-component-sweet-alerts');
  Route::get('block-ui', [ExtensionController::class,'block_ui'])->name('ext-component-block-ui');
  Route::get('toastr', [ExtensionController::class,'toastr'])->name('ext-component-toastr');
  Route::get('slider', [ExtensionController::class,'slider'])->name('ext-component-slider');
  Route::get('drag-drop', [ExtensionController::class,'drag_drop'])->name('ext-component-drag-drop');
  Route::get('tour', [ExtensionController::class,'tour'])->name('ext-component-tour');
  Route::get('clipboard', [ExtensionController::class,'clipboard'])->name('ext-component-clipboard');
  Route::get('plyr', [ExtensionController::class,'plyr'])->name('ext-component-plyr');
  Route::get('context-menu', [ExtensionController::class,'context_menu'])->name('ext-component-context-menu');
  Route::get('swiper', [ExtensionController::class,'swiper'])->name('ext-component-swiper');
  Route::get('tree', [ExtensionController::class,'tree'])->name('ext-component-tree');
  Route::get('ratings', [ExtensionController::class,'ratings'])->name('ext-component-ratings');
  Route::get('locale', [ExtensionController::class,'locale'])->name('ext-component-locale');
});
/* Route Extensions */

/* Route Page Layouts */
Route::group(['prefix' => 'page-layouts'], function () {
  Route::get('collapsed-menu', [PageLayoutController::class,'layout_collapsed_menu'])->name('layout-collapsed-menu');
  Route::get('boxed', [PageLayoutController::class,'layout_boxed'])->name('layout-boxed');
  Route::get('without-menu', [PageLayoutController::class,'layout_without_menu'])->name('layout-without-menu');
  Route::get('empty', [PageLayoutController::class,'layout_empty'])->name('layout-empty');
  Route::get('blank', [PageLayoutController::class,'layout_blank'])->name('layout-blank');
});
/* Route Page Layouts */

/* Route Forms */
Route::group(['prefix' => 'form'], function () {
  Route::get('input', [FormsController::class,'input'])->name('form-input');
  Route::get('input-groups', [FormsController::class,'input_groups'])->name('form-input-groups');
  Route::get('input-mask', [FormsController::class,'input_mask'])->name('form-input-mask');
  Route::get('textarea', [FormsController::class,'textarea'])->name('form-textarea');
  Route::get('checkbox', [FormsController::class,'checkbox'])->name('form-checkbox');
  Route::get('radio', [FormsController::class,'radio'])->name('form-radio');
  Route::get('switch', [FormsController::class,'switch'])->name('form-switch');
  Route::get('select', [FormsController::class,'select'])->name('form-select');
  Route::get('number-input', [FormsController::class,'number_input'])->name('form-number-input');
  Route::get('file-uploader', [FormsController::class,'file_uploader'])->name('form-file-uploader');
  Route::get('quill-editor', [FormsController::class,'quill_editor'])->name('form-quill-editor');
  Route::get('date-time-picker', [FormsController::class,'date_time_picker'])->name('form-date-time-picker');
  Route::get('layout', [FormsController::class,'layouts'])->name('form-layout');
  Route::get('wizard', [FormsController::class,'wizard'])->name('form-wizard');
  Route::get('validation', [FormsController::class,'validation'])->name('form-validation');
  Route::get('repeater', [FormsController::class,'form_repeater'])->name('form-repeater');
});
/* Route Forms */

/* Route Tables */
Route::group(['prefix' => 'table'], function () {
  Route::get('', [TableController::class,'table'])->name('table');
  Route::get('datatable/basic', [TableController::class,'datatable_basic'])->name('datatable-basic');
  Route::get('datatable/advance', [TableController::class,'datatable_advance'])->name('datatable-advance');
  Route::get('ag-grid', [TableController::class,'ag_grid'])->name('ag-grid');
});
/* Route Tables */

/* Route Pages */
Route::group(['prefix' => 'page'], function () {
  Route::get('account-settings', [PagesController::class,'account_settings'])->name('page-account-settings');
  Route::get('profile', [PagesController::class,'profile'])->name('page-profile');
  Route::get('faq', [PagesController::class,'faq'])->name('page-faq');
  Route::get('knowledge-base', [PagesController::class,'knowledge_base'])->name('page-knowledge-base');
  Route::get('knowledge-base/category', [PagesController::class,'kb_category'])->name('page-knowledge-base3');
  Route::get('knowledge-base/category/question', [PagesController::class,'kb_question'])->name('page-knowledge-base2');
  Route::get('pricing', [PagesController::class,'pricing'])->name('page-pricing');
  Route::get('blog/list', [PagesController::class,'blog_list'])->name('page-blog-list');
  Route::get('blog/detail', [PagesController::class,'blog_detail'])->name('page-blog-detail');
  Route::get('blog/edit', [PagesController::class,'blog_edit'])->name('page-blog-edit');

  // Miscellaneous Pages With Page Prefix
  Route::get('coming-soon', [MiscellaneousController::class,'coming_soon'])->name('misc-coming-soon');
  Route::get('not-authorized', [MiscellaneousController::class,'not_authorized'])->name('misc-not-authorized');
  Route::get('maintenance', [MiscellaneousController::class,'maintenance'])->name('misc-maintenance');
});
/* Route Pages */
Route::get('/error', [MiscellaneousController::class,'error'])->name('error');

/* Route Authentication Pages */
Route::group(['prefix' => 'auth'], function () {
  Route::get('login-v1', [AuthenticationController::class,'login_v1'])->name('auth-login-v1');
  Route::get('login-v2', [AuthenticationController::class,'login_v2'])->name('auth-login-v2');
  Route::get('register-v1', [AuthenticationController::class,'register_v1'])->name('auth-register-v1');
  Route::get('register-v2', [AuthenticationController::class,'register_v2'])->name('auth-register-v2');
  Route::get('forgot-password-v1', [AuthenticationController::class,'forgot_password_v1'])->name('auth-forgot-password-v1');
  Route::get('forgot-password-v2', [AuthenticationController::class,'forgot_password_v2'])->name('auth-forgot-password-v2');
  Route::get('reset-password-v1', [AuthenticationController::class,'reset_password_v1'])->name('auth-reset-password-v1');
  Route::get('reset-password-v2', [AuthenticationController::class,'reset_password_v2'])->name('auth-reset-password-v2');
  Route::get('lock-screen', [AuthenticationController::class,'lock_screen'])->name('auth-lock_screen');
});
/* Route Authentication Pages */

/* Route Charts */
Route::group(['prefix' => 'chart'], function () {
  Route::get('apex', [ChartsController::class,'apex'])->name('chart-apex');
  Route::get('chartjs', [ChartsController::class,'chartjs'])->name('chart-chartjs');
  Route::get('echarts', [ChartsController::class,'echarts'])->name('chart-echarts');
});
/* Route Charts */

// map leaflet
Route::get('/maps/leaflet', [ChartsController::class,'maps_leaflet'])->name('map-leaflet');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);


Route::get('/home', [InfoController::class, 'index'])->name('home');

Route::get('/about', [InfoController::class, 'about'])->name('about');

Route::get('/contact', [InfoController::class, 'contact'])->name('contact');

Route::post('/contact', [InfoController::class, 'storeContact'])->name('contact-send');




/**
 * 
 * Admin Routes
 * 
 */

//Services routes
Route::get('/services/list', [ServicesController::class, 'index_admin'])->name('services_index_admin');
Route::get('/services/show/{id}/admin/{message?}', [ServicesController::class, 'show_admin'])->name('services_show_admin');
Route::get('/services/edit/{id}', [ServicesController::class, 'edit'])->name('services_edit');
Route::get('/services/create', [ServicesController::class, 'create'])->name('services_create');
Route::post('/services/store', [ServicesController::class, 'store'])->name('services_store');
Route::post('/services/update/{id}', [ServicesController::class, 'update'])->name('services_update');
Route::post('/services/destroy', [ServicesController::class, 'destroy'])->name('services_destroy');
Route::get('/services', [ServicesController::class, 'index'])->name('services_index');
Route::get('/services/{id}', [ServicesController::class, 'show'])->name('services_view');

//Projects routes
Route::get('/projects/list', [ProjectsController::class, 'index_admin'])->name('projects_index_admin');
Route::get('/projects/show/{id}/admin/{message?}', [ProjectsController::class, 'show_admin'])->name('projects_show_admin');
Route::get('/projects/edit/{id}', [ProjectsController::class, 'edit'])->name('projects_edit');
Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects_create');
Route::post('/projects/store', [ProjectsController::class, 'store'])->name('projects_store');
Route::post('/projects/update/{id}', [ProjectsController::class, 'update'])->name('projects_update');
Route::post('/projects/destroy', [ProjectsController::class, 'destroy'])->name('projects_destroy');
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects_index');
Route::get('/projects/{id}', [ProjectsController::class, 'show'])->name('projects_view');
Route::get('/projects/list/{category_id}', [ProjectsController::class, 'show_category'])->name('project_view_category');

//Blog routes
Route::get('/blog/list', [BlogController::class, 'index_admin'])->name('blog_index_admin');
Route::get('/blog/show/{id}/admin/{message?}', [BlogController::class, 'show_admin'])->name('blog_show_admin');
Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog_edit');
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog_create');
Route::post('/blog/store', [BlogController::class, 'store'])->name('blog_store');
Route::post('/blog/update/{id}', [BlogController::class, 'update'])->name('blog_update');
Route::post('/blog/destroy', [BlogController::class, 'destroy'])->name('blog_destroy');
Route::get('/blog', [BlogController::class, 'index'])->name('blog_index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog_view');
Route::get('/blog/list/{category_id}', [BlogController::class, 'show_category'])->name('blog_view_category');

//Blog Categories routes
Route::get('/blog/category/list', [BlogCategoriesController::class, 'index'])->name('blog_categories_index');
Route::get('/blog/category/show/{id}/{message?}', [BlogCategoriesController::class, 'show'])->name('blog_category_show');
Route::get('/blog/category/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('blog_category_edit');
Route::get('/blog/category/create', [BlogCategoriesController::class, 'create'])->name('blog_category_create');
Route::post('/blog/category/store', [BlogCategoriesController::class, 'store'])->name('blog_category_store');
Route::post('/blog/category/update/{id}', [BlogCategoriesController::class, 'update'])->name('blog_category_update');
Route::post('/blog/category/destroy', [BlogCategoriesController::class, 'destroy'])->name('blog_category_destroy');

//Art routes
Route::get('/art', [ArtController::class, 'index'])->name('art_index');
Route::get('/art/admin', [ArtController::class, 'index_admin'])->name('art_index_admin');

//Paint routes
Route::get('/art/paint/show/{id}/{message?}', [PaintController::class, 'show_admin'])->name('paint_show_admin');
Route::get('/art/paint/edit/{id}', [PaintController::class, 'edit'])->name('paint_edit');
Route::get('/art/paint/create', [PaintController::class, 'create'])->name('paint_create');
Route::post('/art/paint/store', [PaintController::class, 'store'])->name('paint_store');
Route::post('/art/paint/update/{id}', [PaintController::class, 'update'])->name('paint_update');
Route::post('/art/paint/destroy', [PaintController::class, 'destroy'])->name('paint_destroy');
Route::get('/art/paint', [PaintController::class, 'index'])->name('paint_index');
Route::get('/art/paint/{id}', [PaintController::class, 'show'])->name('paint_show');

//Paint Collection routes
Route::get('/art/paint/{idCategory}/list', [PaintCollectionController::class, 'index'])->name('paint_collection_index');
Route::get('/art/paint/{idCategory}/list/admin', [PaintCollectionController::class, 'index_admin'])->name('paint_collection_index_admin');
Route::get('/art/paint/collection/create', [PaintCollectionController::class, 'create'])->name('paint_collection_create');
Route::post('/art/paint/{idCategory}/list', [PaintCollectionController::class, 'store'])->name('paint_collection_store');
Route::get('/art/paint/{idCategory}/list', [PaintCollectionController::class, 'edit'])->name('paint_collection_edit');
Route::post('/art/paint/{idCategory}/list', [PaintCollectionController::class, 'update'])->name('paint_collection_update');
Route::post('/art/paint/{idCategory}/list', [PaintCollectionController::class, 'destroy'])->name('paint_collection_destroy');

//Exhibition routes
Route::get('/art/exhibtion/show/{id}/{message?}', [ExhibitionController::class, 'show_admin'])->name('exhibition_show_admin');
Route::get('/art/exhibtion/edit/{id}', [ExhibitionController::class, 'edit'])->name('exhibition_edit');
Route::get('/art/exhibtion/create', [ExhibitionController::class, 'create'])->name('exhibition_create');
Route::post('/art/exhibtion/store', [ExhibitionController::class, 'store'])->name('exhibition_store');
Route::post('/art/exhibtion/update/{id}', [ExhibitionController::class, 'update'])->name('exhibition_update');
Route::post('/art/exhibtion/destroy', [ExhibitionController::class, 'destroy'])->name('exhibition_destroy');
Route::get('/art/exhibtion/', [ExhibitionController::class, 'index'])->name('exhibition_index');
Route::get('/art/exhibtion/{id}', [ExhibitionController::class, 'show'])->name('exhibition_show');

//Images routes
Route::get('/images/upload/{modelType}/{modelId}', [ImagesController::class, 'create'])->name('images_create_model');
Route::post('/images/store/{modelType}/{modelId}', [ImagesController::class, 'store'])->name('images_store');
Route::get('/images/edit/{modelType}/{modelId}', [ImagesController::class, 'edit'])->name('images_edit');
Route::post('/images/delete/{modelType}/{modelId}', [ImagesController::class, 'delete'])->name('images_delete');
//->middleware('auth');


require __DIR__.'/auth.php';
