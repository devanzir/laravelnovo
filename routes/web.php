<?php
#use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/product/{slug}', 'HomeController@single')->name('product.single');

Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

#Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

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

        #Route::resource('stores', 'Admin\StoreController');  

    });
});
Auth::routes();  
   
Route::get('/model', function () { }); 

















// Route::prefix('stores')->name('stores.')->group(function () {

    //     Route::get('/', 'StoreController@index')->name('index');

    //     Route::get('/create', 'StoreController@create')->name('create');

    //     Route::post('/store', 'StoreController@store')->name('store');

    //     Route::get('/{store}/edit', 'StoreController@edit')->name('edit');

    //     Route::post('/update/{store}', 'StoreController@update')->name('update');

    //     Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');
    // });





#Route::get('/home', 'HomeController@index')->name('home');







    #$products = \App\Product::all();
    #return $products;

    #$user = new \App\User(); 
    #$user->name = 'Usuario Teste';
    #$user->email = 'email30@teste.com';
    #$user->password = bcrypt('123456789');

    #$user = \App\User::create([
    #'name' => 'junior fritz',
    #'email' => 'teste@email,com',
    # 'password' => bcrypt('1234ghd')
    # ]);

    #dd($user);
    # $user = \App\User::find(48);
    # $user ->update([
    #    'name' => 'Atualizando com Mass Update'
    # ]);
    #dd($user);

    #como pegar so uma loja de um usuario.

    # $user =\App\User::find(4);
    #return $user->store;

    // $user = \App\User::find(10);
    // $store = $user->store()->create([
    //     'name' =>'loja teste',
    //     'description' => 'Loja teste de produtos de informatica',
    //     'mobile_phone' => 'XXXX-XXXX-XX',
    //     'phone'=> 'XXX-XXX-XX',
    //     'slug' => 'Loja-teste'

    // ]);

    // dd($store);

    // $store = \App\Store::find(41);
    // $product = $store->products()->create([
    //     'name' => 'not DELL',
    //     'description' => 'core i 5',
    //     'body' => 'Qualquer coisa',
    //     'price' => 2999.90,
    //     'slug' => 'noot-dell',
    // ]);

    // dd($product);

    //     \App\Category::create([
    //         'name' => 'Games',
    //         'description' => null,
    //         'slug' => 'games'
    //     ]);

    //     \App\Category::create([
    //         'name' => 'Nootboock',
    //         'description' => null,
    //         'slug' => 'nootboock'
    //     ]);

    //    return\App\Category::all();
    // $product =\App\Product::find(41);

    // dd($product->categories()->sync([2]));



    // return \App\User::all();


    // });
