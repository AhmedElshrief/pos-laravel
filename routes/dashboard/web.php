<?php


use App\Http\Controllers\Dashboard\DashboardController;


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // users routes
        Route::resource('users', 'UserController')->except(['show']);

        // category routes
        Route::resource('categories', 'CategoryController')->except(['show']);

        // product routes
        Route::resource('products', 'ProductController')->except(['show']);

        // client routes
        Route::resource('clients', 'ClientController')->except(['show']);
        Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

        // orders
        Route::resource('orders', 'OrderController');
        Route::get('orders/{order}/products', 'OrderController@products')->name('orders.products');
        Route::delete('orders/{order}/restore', 'OrderController@restore')->name('orders.restore');

    }); //end of dashboard


});


