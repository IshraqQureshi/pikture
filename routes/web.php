<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrintOptionController;
use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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
Route::get('/cc', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

Route::get('/linkstorage', function () {
    Artisan::call('cache:clear');
    Artisan::call('storage:link');
});


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // Redirect to the home page if authenticated
    } else {
        return view('auth.login'); // Show the login page if not authenticated
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {        
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource('events', EventController::class);
        Route::resource('photos', PhotoController::class);
        Route::resource('invitations', InvitationController::class);
        Route::resource('/comments', CommentController::class);
        Route::get('/gallery', [PhotoController::class, 'gallery'])->name('gallery');
        Route::get('/event-gallery', [PhotoController::class, 'eventGallery'])->name('event.gallery');
        Route::get('/get-comments', [CommentController::class, 'getComments'])->name('get-comments');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile-update', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::post('/setting-update', [HomeController::class, 'settingUpdate'])->name('setting.update');
        Route::get('/smtp-setting', [HomeController::class, 'smtpSetting'])->name('smtp.setting');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');
        Route::post('/smtp-update', [HomeController::class, 'smtpUpdate'])->name('smtp.update');

        Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

        Route::get('add-cart/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart');

        Route::get('cart', [OrderController::class, 'cart'])->name('order.cart');
        Route::post('update-cart{id}', [OrderController::class, 'updateCart'])->name('order.updateCart');

        Route::post('order-checkout', [OrderController::class, 'checkout'])->name('order.checkout');


        Route::get('orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('orders/{id}', [OrderController::class, 'view'])->name('order.view');


        Route::get('print-option', [PrintOptionController::class, 'index'])->name('print-option.index');
        Route::get('print-option/create', [PrintOptionController::class, 'create'])->name('print-option.create');
        Route::get('print-option/{id}', [PrintOptionController::class, 'view'])->name('print-option.show');
        Route::get('print-option/edit/{id}', [PrintOptionController::class, 'edit'])->name('print-option.edit');
        Route::put('print-option/update/{id}', [PrintOptionController::class, 'update'])->name('print-option.update');
        Route::post('print-option/store', [PrintOptionController::class, 'store'])->name('print-option.store');
        Route::delete('print-option/destroy/{id}', [PrintOptionController::class, 'destroy'])->name('print-option.destroy');

        Route::get('shipping', [ShippingController::class, 'index'])->name('shipping.index');
        Route::get('shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::get('shipping/{id}', [ShippingController::class, 'view'])->name('shipping.show');
        Route::get('shipping/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('shipping/update/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::post('shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::delete('shipping/destroy/{id}', [ShippingController::class, 'destroy'])->name('shipping.destroy');
    });
