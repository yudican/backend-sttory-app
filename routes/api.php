<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function () {

    // AUTH
    Route::post('register', 'Api\Auth\RegisterController@store')->name('register');
    Route::post('login', 'Api\Auth\LoginController@login')->name('login');

    Route::group(['middleware' => ['cde', 'auth:api'], 'namespace' => 'Api'], function () {
        // AUTH
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('genre', 'GenresController@index')->name('genre');
        Route::get('licence', 'LicenceController@index')->name('licence');

        Route::post('story/{story}/part', 'PartController@store')->name('part.store');
        // Review
        Route::get('story/{story}/review', 'ReviewController@index')->name('review.index');
        Route::post('story/{story}/review', 'ReviewController@store')->name('review.store');
        // checkout
        Route::post('story/{story}/checkout', 'CheckoutController@checkout')->name('story.checkout');
        // read
        Route::get('story/{story}/read', 'StoryController@read')->name('story.read');
        // get by genre
        Route::get('story/{story}/genre', 'StoryController@getStoryByGenre')->name('story.genre');
        Route::get('story/popular', 'StoryController@getPopularStory')->name('story.popular');

        // library
        Route::get('library/{library}', 'LibraryController@updateExpired')->name('library.update-expired');
        // story
        Route::apiResource('story', 'StoryController');

        Route::apiResource('part', 'PartController')->except(['store']);

        // WALLET
        Route::get('wallet/balance', 'WalletController@index')->name('wallet.index');
        Route::post('wallet/topup', 'WalletController@topUp')->name('wallet.topup');

        // user
        Route::post('user/select-genre', 'UserController@selectGenre')->name('user.select-genre');
        // profile
        Route::get('user/profile', 'ProfileController@index')->name('user.profile');
        Route::post('user/profile', 'ProfileController@store')->name('user.store');
    });
});
