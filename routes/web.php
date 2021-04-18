<?php

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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chart', 'HomeController@chart')->name('chart');

Route::namespace('User')
    ->prefix('user')
    ->name('user.')
    ->middleware(['auth'])
    ->group(function () {
        Route::prefix('role')
            ->name('role.')
            ->group(function () {
                Route::get('/', 'UserRole@index')->name('home');
                Route::get('/create', 'UserRole@create')->name('create.form');
                Route::get('/edit/{id}', 'UserRole@edit')->name('edit.form');
                Route::get('/{id}', 'UserRole@show')->name('view');

                Route::post('/', 'UserRole@store')->name('save');
                Route::put('/{id}', 'UserRole@update')->name('update');
                Route::delete('/{id}', 'UserRole@destroy')->name('delete');

            });
        Route::prefix('{user_id}')->group(function() {
            Route::prefix('expense')
                ->name('expense.')
                ->group(function () {
                    Route::get('/', 'UserExpense@index')->name('home');
                    Route::get('/create', 'UserExpense@create')->name('create.form');
                    Route::get('/edit/{id}', 'UserExpense@edit')->name('edit.form');
                    Route::get('/{id}', 'UserExpense@show')->name('view');

                    Route::post('/', 'UserExpense@store')->name('save');
                    Route::put('/{id}', 'UserExpense@update')->name('update');
                    Route::delete('/{id}', 'UserExpense@destroy')->name('delete');

                });
        });
        
        Route::get('/', 'User@index')->name('home');
        Route::get('/create', 'User@create')->name('create.form');
        Route::get('/edit/{id}', 'User@edit')->name('edit.form');
        Route::get('/{id}', 'User@show')->name('view');

        Route::post('/', 'User@store')->name('save');
        Route::put('/{id}', 'User@update')->name('update');
        Route::delete('/{id}', 'User@destroy')->name('delete');
    });

Route::namespace('Expense')
    ->prefix('expense')
    ->name('expense.')
    ->middleware(['auth'])
    ->group(function () {

        Route::prefix('category')
            ->name('category.')
            ->group(function () {
                Route::get('/', 'ExpenseCategory@index')->name('home');
                Route::get('/create', 'ExpenseCategory@create')->name('create.form');
                Route::get('/edit/{id}', 'ExpenseCategory@edit')->name('edit.form');
                Route::get('/{id}', 'ExpenseCategory@show')->name('view');

                Route::post('/', 'ExpenseCategory@store')->name('save');                
                Route::put('/{id}', 'ExpenseCategory@update')->name('update');                
                Route::delete('/{id}', 'ExpenseCategory@destroy')->name('delete');
            });

        Route::get('/', 'Expense@index')->name('home');
        Route::get('/create', 'Expense@create')->name('create.form');
        Route::get('/edit/{id}', 'Expense@edit')->name('edit.form');
        Route::get('/{id}', 'Expense@show')->name('view');

        Route::post('/', 'Expense@store')->name('save');
        Route::put('/{id}', 'Expense@update')->name('update');
        Route::delete('/{id}', 'Expense@destroy')->name('delete');
    });

Route::get('/', function () {
    return view('welcome');
});