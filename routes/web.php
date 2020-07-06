<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('brackets/admin-auth::admin/login');
});
// Auth::routes();

// Route::group(['middleware' => ['auth']], function () {

//     Route::get('/home', 'HomeController@index')->name('home');

//     Route::get('genre/json', 'GenreController@json')->name('genre.json');
//     Route::resource('genre', 'GenreController');
// });


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('genres')->name('genres/')->group(static function () {
            Route::get('/',                                             'GenresController@index')->name('index');
            Route::get('/create',                                       'GenresController@create')->name('create');
            Route::post('/',                                            'GenresController@store')->name('store');
            Route::get('/{genre}/edit',                                 'GenresController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'GenresController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{genre}',                                     'GenresController@update')->name('update');
            Route::delete('/{genre}',                                   'GenresController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('licences')->name('licences/')->group(static function () {
            Route::get('/',                                             'LicencesController@index')->name('index');
            Route::get('/create',                                       'LicencesController@create')->name('create');
            Route::post('/',                                            'LicencesController@store')->name('store');
            Route::get('/{licence}/edit',                               'LicencesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LicencesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{licence}',                                   'LicencesController@update')->name('update');
            Route::delete('/{licence}',                                 'LicencesController@destroy')->name('destroy');
        });
    });
});
