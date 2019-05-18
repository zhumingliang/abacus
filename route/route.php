<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('api/:version/token/admin', 'api/:version.Token/getAdminToken');
Route::get('api/:version/token/login/out', 'api/:version.Token/loginOut');


Route::post('api/:version/booking', 'api/:version.Booking/save');
Route::get('api/:version/bookings', 'api/:version.Booking/bookings');
Route::post('api/:version/booking/handel', 'api/:version.Booking/handel');

Route::post('api/:version/category', 'api/:version.Index/category');
Route::post('api/:version/category/update', 'api/:version.Index/categoryUpdate');
Route::post('api/:version/category/handel', 'api/:version.Index/categoryHandel');
Route::post('api/:version/service', 'api/:version.Index/serviceIndex');
Route::post('api/:version/service/handel', 'api/:version.Index/serviceHandel');
Route::post('api/:version/service/update', 'api/:version.Index/serviceUpdate');
Route::get('api/:version/categories', 'api/:version.Index/categories');

Route::post('api/:version/image', 'api/:version.Image/save');
Route::post('api/:version/image/url', 'api/:version.Image/saveToUrl');

Route::post('api/:version/apply', 'api/:version.Apply/save');
Route::get('api/:version/applies', 'api/:version.Apply/applies');
Route::post('api/:version/apply/handel', 'api/:version.Apply/handel');

Route::post('api/:version/information/save', 'api/:version.information/save');
Route::get('api/:version/informations', 'api/:version.information/informations');
Route::get('api/:version/information', 'api/:version.information/information');
Route::post('api/:version/information/update', 'api/:version.information/update');
Route::post('api/:version/information/handel', 'api/:version.information/handel');

