<?php

use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/product/{slug}', 'HomeController@single')->name('product.single');

Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::get('remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('cancel', 'CartController@cancel')->name('cancel');

});


Route::prefix('checkout')->name('checkout.')->group(function(){
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
});

Route::group(['middleware' => ['auth']], function(){
    
    
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

        Route::resource('stores', 'StoreController');
    
        Route::resource('products', 'ProductController');

        Route::resource('categories', 'CategoryController');   
        

        Route::post('photos/remove','ProductPhotoController@removePhoto')->name('photo.remove');

    });
});
Auth::routes();  
   
Route::get('/model', function () { }); 

















