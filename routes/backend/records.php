<?php



Route::group(['middleware' => ['auth','role']], function () {

    #####################RUTA PARA CATEGORIAS####################################
    Route::get('categories', 'Backend\CategoryController@index')
        ->name('categories')
        ->defaults('route', 'categories');

    Route::get('category/edit/{id}', 'Backend\CategoryController@edit')
        ->name('category.edit')
        ->defaults('route', 'categories');

    Route::get('category/create/new', 'Backend\CategoryController@create')
        ->name('category.create')
        ->defaults('route', 'categories');

    Route::post('category/store', 'Backend\CategoryController@store')
        ->name('category.store');

    Route::post('category/update', 'Backend\CategoryController@update')
        ->name('category.update');

    Route::post('category/destroy', 'Backend\CategoryController@destroy')
        ->name('category.destroy');
});