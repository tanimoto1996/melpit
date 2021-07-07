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

Route::get('', 'ItemsController@showItems')->name('top');
Route::get('items/{item}', 'ItemsController@showItemDetail')->name('item');

Auth::routes();

Route::prefix('mypage')->namespace('MyPage')->middleware('auth')
    ->group(function() {
        Route::get('edit-profile', 'ProfileController@showProfileEditForm')->name("mypage.edit-profile");
        Route::post('edit-profile', 'ProfileController@editProfile')->name("mypage.edit-profile");
        Route::get('bought-items', 'BoughtItemsController@showBoughtItems')->name("mypage.bought-items");
        Route::get('sold-items', 'SoldItemsController@showSolidItems')->name("mypage.sold-items");
    });

Route::middleware('auth')->group(function() {
    Route::get('items/{item}/buy', 'itemsController@showBuyItemForm')->name('item.buy');
    Route::post('items/{item}/buy', 'itemsController@buyItem')->name('item.buy');
    Route::get('sell', 'SellController@showSellForm')->name('sell');
    Route::post('sell', 'SellController@sellItem')->name('sell');
});

