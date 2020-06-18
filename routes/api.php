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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['cors'])->group(function () {
    // Route::options('accounts', function () {
    //     return response()->json();
    // });
    Route::get('click', 'Api\ClickController@action');
    Route::get('link_click', 'Api\ClickController@link_action');
    Route::get('scrollposition', 'Api\ClickController@scroll_action');
    // Route::match('options','scrollposition', 'Api\ClickController@scroll_action');
    Route::get('click_heatmap', 'Api\ClickController@heatmap');
    Route::get('screen_time_heatmap', 'Api\ClickController@screen_time_heatmap');

});