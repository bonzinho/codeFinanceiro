<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'cors', 'as' => 'api.'], function(){

    Route::post('access_token', 'Api\AuthController@accessToken')->name('access_token');
    Route::post('refresh_token', 'Api\AuthController@refreshToken')->name('refresh_token');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::resource('banks', 'Api\BanksController', ['only' => ['index']]);
        Route::resource('bank_accounts', 'Api\BankAccountsController', ['except' => ['create', 'edit']]); // cria todas as rotas necessarias de forma automatica o except faz com que não crie as rotas definidas nele, neste caso crete e edit
        Route::resource('categories', 'Api\CategoriesController', ['except' => ['create', 'edit']]); // cria todas as rotas necessarias de forma automatica o except faz com que não crie as rotas definidas nele, neste caso crete e edit
        Route::post('logout', 'Api\AuthController@logout')->middleware('auth:api')->name('logout');
        Route::get('/user', function(Request $request){
            $user = $request->user('api');  // aqui é necessario defnir o guardiao, neste caso api, se não for definido usa o web, faz com que use cookies em vez de localstore
            return $user;     
        })->middleware('auth:api')->name('user'); // adiciona o nosso midleware para uqe o nosso jwt seja ativo

    });
    
});


