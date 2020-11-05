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
Route::group(['middleware' => 'auth'], function(){
    //Web
    Route::get('/mitsumori/list', 'SearchController@index')->name('search.index');
    Route::get('/mitsumori/list/search', 'SearchController@search')->name('search.search');
    Route::get('/mitsumori/list/search/details/{denpyou_number}', 'DetailController@index')->name('detail.index');

    Route::get('/mitsumori/create', 'CreateController@index')->name('create.index');
    Route::post('/mitsumori/create', 'CreateController@insert')->name('create.insert');
    Route::post('/mitsumori/create/success', 'CreateController@success')->name('create.success');

    //API
    Route::get('/api/mitsumori/search/number/{product_number}', 'MitsumoriApiController@getProcutName');
    Route::get('/api/mitsumori/search/name/{product_name}', 'MitsumoriApiController@getProductNumber');
    Route::get('/api/mitsumori/search/{user_code}/{product_number}', 'MitsumoriApiController@getUnitPrice');

    Route::get('/api/mitsumori/pdf/{denpyou_number}', 'MitsumoriApiController@getQuote');//PDF作成
    Route::post('/api/mitsumori/delete', 'MitsumoriApiController@deleteQuote');//見積伝票削除

    Route::get('/', 'HomeController@index')->name('home');
});
Auth::routes();
