<?php

Route::group([
    'prefix' => config('clara.dataflow.route.web.prefix'), 
    'middleware' => config('clara.dataflow.route.web.middleware')
], 
function()
{
    Route::resource('dataflow', 'DataflowController', ['names' => 'admin.dataflow']);
});

Route::group([
    'prefix' => config('clara.dataflow.route.api.prefix'), 
    'middleware' => config('clara.dataflow.route.api.middleware')
], 
function()
{
    Route::get('dataflow/{format}/{token}/{param?}', 'DataflowController@index')->name('api.dataflow');
});