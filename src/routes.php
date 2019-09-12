<?php

Route::group([
    'prefix' => config('clara.dataflow.route.web.prefix'), 
    'middleware' => config('clara.dataflow.route.web.middleware')
], 
function()
{
    Route::resource('dataflow', 'CeddyG\ClaraDataflow\Http\Controllers\Admin\DataflowController', ['names' => 'admin.dataflow']);
});

Route::group([
    'prefix' => config('clara.dataflow.route.api-admin.prefix'), 
    'middleware' => config('clara.dataflow.route.api-admin.middleware')
], 
function()
{
    Route::get('dataflow/index/ajax', 'CeddyG\ClaraDataflow\Http\Controllers\Admin\DataflowController@indexAjax')->name('admin.dataflow.index.ajax');
	Route::get('dataflow/select/ajax', 'CeddyG\ClaraDataflow\Http\Controllers\Admin\DataflowController@selectAjax')->name('admin.dataflow.select.ajax');
});

Route::group([
    'prefix' => config('clara.dataflow.route.api.prefix'), 
    'middleware' => config('clara.dataflow.route.api.middleware')
], 
function()
{
    Route::get('dataflow/{format}/{token}/{param?}', 'CeddyG\ClaraDataflow\Http\Controllers\DataflowController@index')->name('api.dataflow');
});