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

////
    // OLD VERSION UNAUTHENTICATED //
////

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// //  List All Articles
// Route::get('articles', 'ArticleController@index');



// //  Create New Article
// Route::post('/article', 'ArticleController@store');

// //  List Single Article
// Route::get('/article/{article}', 'ArticleController@show');

// //  Update Article [deprecating route]
// // Route::put('article', 'ArticleController@store');

// Route::patch('/article/{article}', 'ArticleController@update');

// //  Delete Article
// Route::delete('article/{article}', 'ArticleController@destroy');


//  All Routes Need Authenticating
Route::middleware('auth:api')->group(function() {

    //  List All Articles
    Route::get('/articles', 'ArticleController@index');

    //  Create New Article
    Route::post('/article', 'ArticleController@store');

    //  List Single Article
    Route::get('/article/{article}', 'ArticleController@show');

    Route::patch('/article/{article}', 'ArticleController@update');

    //  Delete Article
    Route::delete('article/{article}', 'ArticleController@destroy');

});

