<?php



Route::group(['middleware' => ['auth','role']], function () {

    #####################RUTA PARA REGISTROS PAGINAS ESTATICAS#################################################
    Route::match(['get', 'post'], '/static-pages', 'Backend\StaticPageController@index')->name('StaticPage.index')->defaults('route', 'StaticPage.index');

    Route::match(['get', 'post'], 'static-page-create', 'Backend\StaticPageController@create')->name('StaticPage.create')->defaults('route', 'StaticPage.index');

    Route::post('/store-static-page', 'Backend\StaticPageController@store')->name('StaticPage.store');

    Route::match(['get', 'post'], '/edit-static-page/{id}', 'Backend\StaticPageController@edit')->name('StaticPage.edit')->defaults('route', 'StaticPage.index');

    Route::post('/update-static-page', 'Backend\StaticPageController@update')->name('StaticPage.update');

    Route::post('/destroy-static-page', 'Backend\StaticPageController@destroy')->name('StaticPage.delete');

});