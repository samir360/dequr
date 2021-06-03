<?php

use App\Models\StaticPage;

Route::get('backend/login', function () {
    return view('backend.login');
});

Route::match(['get', 'post'], 'login', 'Auth\LoginController@showFrmLogin')->name('login');

Route::match(['get', 'post'], 'register', 'Auth\RegisterController@index')->name('register');

Route::match(['get', 'post'], 'register-create', 'Auth\RegisterController@create')->name('register.create');

Route::match(['get', 'post'], 'login-user', 'Auth\LoginController@login')->name('login_user');

Route::get('/home', 'Frontend\HomeController@index')->name('home');

Route::get('/', 'Frontend\HomeController@index')->name('principal');

Route::get('category', 'Frontend\CategoryController@index')->name('category');

Route::get('detail-category', 'Frontend\DetailCategoryController@index')->name('detail_category');

Route::get('terms_and_conditions', 'Backend\StaticPageController@show')->name('terms_and_conditions')->defaults('page', StaticPage::TERMS_AND_CONDITIONS);

Route::get('legal', 'Backend\StaticPageController@show')->name('legal')->defaults('page', StaticPage::LEGAL);

Route::get('companies', 'Frontend\CompanyController@index')->name('Company.index');

Route::get('company', 'Frontend\CompanyController@show')->name('Company.show');

Route::get('complaints', 'Frontend\ComplaintController@index')->name('Complaint.index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('post-complaint', 'Frontend\PostComplaintController@index')->name('PostComplaint.index');

    Route::get('profile', 'Frontend\ProfileController@index')->name('profile.index');

    Route::get('notifications', 'Frontend\NotificationController@index')->name('Notification.index');

    Route::get('comments', 'Frontend\CommentController@index')->name('Comment,index');
});
