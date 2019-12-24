<?php

Route::group([
    'prefix' => config('clara.dataflow.route.web.prefix'), 
    'middleware' => config('clara.dataflow.route.web.middleware')
], 
function()
{
    Route::resource('dataflow', config('clara.dataflow.controller-admin'), ['names' => 'admin.dataflow']);
});

Route::group([
    'prefix' => config('clara.dataflow.route.api-admin.prefix'), 
    'middleware' => config('clara.dataflow.route.api-admin.middleware')
], 
function()
{
    Route::get('dataflow/index/ajax', config('clara.dataflow.controller-admin').'@indexAjax')->name('admin.dataflow.index.ajax');
	Route::get('dataflow/select/ajax', config('clara.dataflow.controller-admin').'@selectAjax')->name('admin.dataflow.select.ajax');
});

Route::group([
    'prefix' => config('clara.dataflow.route.api.prefix'), 
    'middleware' => config('clara.dataflow.route.api.middleware')
], 
function()
{
    Route::get('dataflow/{format}/{token}/{param?}', config('clara.dataflow.controller').'@index')->name('api.dataflow');
});