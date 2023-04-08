<?php


use App\Http\Controllers\Dashboard\DashboardController;


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // categories routes
        Route::resource('users', 'UserController')->except(['show']);

        // category routes
        Route::resource('categories', 'CategoryController')->except(['show']);

    }); //end of dashboard


});


