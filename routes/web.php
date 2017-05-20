<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//登录
Route::get('/admin/login/login', '\App\Http\Controllers\Admin\LoginController@login');
Route::post('/admin/login/login', '\App\Http\Controllers\Admin\LoginController@loginpost');
//注销登录
Route::get('/admin/login/loginout/{id}', '\App\Http\Controllers\Admin\LoginController@loginout');

Route::group(['middleware' => ['admin.login', 'admin.operateAuth']], function () {

    //首页
    Route::get('/admin/dashboard/index', '\App\Http\Controllers\Admin\IndexController@index');

    //角色模块
    Route::get('/admin/role/getData', '\App\Http\Controllers\Admin\RoleController@getData');
    Route::get('/admin/role/index', '\App\Http\Controllers\Admin\RoleController@index');
    Route::get('/admin/role/add', '\App\Http\Controllers\Admin\RoleController@add');
    Route::post('/admin/role/add', '\App\Http\Controllers\Admin\RoleController@addpost');
    Route::get('/admin/role/edit/{id}', '\App\Http\Controllers\Admin\RoleController@edit');
    Route::post('/admin/role/edit/{id}', '\App\Http\Controllers\Admin\RoleController@editpost');
    Route::get('/admin/role/del/{id}', '\App\Http\Controllers\Admin\RoleController@del');
    Route::get('/admin/role/access/{id}', '\App\Http\Controllers\Admin\RoleController@access');
    Route::get('/admin/role/accessAdd', '\App\Http\Controllers\Admin\RoleController@accessAdd');

    //管理员模块
    Route::get('/admin/admin/getData', '\App\Http\Controllers\Admin\AdminController@getData');
    Route::get('/admin/admin/index/{rid?}', '\App\Http\Controllers\Admin\AdminController@index');
    Route::get('/admin/admin/add', '\App\Http\Controllers\Admin\AdminController@add');
    Route::post('/admin/admin/add', '\App\Http\Controllers\Admin\AdminController@addpost');
    Route::get('/admin/admin/edit/{id}', '\App\Http\Controllers\Admin\AdminController@edit');
    Route::post('/admin/admin/edit/{id}', '\App\Http\Controllers\Admin\AdminController@editpost');
    Route::get('/admin/admin/del/{id}', '\App\Http\Controllers\Admin\AdminController@del');
    Route::get('/admin/admin/loginlog', '\App\Http\Controllers\Admin\AdminController@loginlog');
    Route::get('/admin/admin/operatelog', '\App\Http\Controllers\Admin\AdminController@operatelog');
    Route::get('/admin/admin/sendmsg/{id}', '\App\Http\Controllers\Admin\AdminController@sendmsg');
    Route::post('/admin/admin/sendmsg/{id}', '\App\Http\Controllers\Admin\AdminController@sendmsgpost');
    Route::get('/admin/admin/allmsg', '\App\Http\Controllers\Admin\AdminController@allmsg');
    Route::get('/admin/admin/read/{id}', '\App\Http\Controllers\Admin\AdminController@read');
    Route::get('/admin/admin/delmsg/{id}', '\App\Http\Controllers\Admin\AdminController@delmsg');
    Route::get('/admin/admin/readAll', '\App\Http\Controllers\Admin\AdminController@readAll');

    //栏目模块
    Route::get('/admin/class/getData', '\App\Http\Controllers\Admin\ClassController@getData');
    Route::get('/admin/class/index', '\App\Http\Controllers\Admin\ClassController@index');
    Route::get('/admin/class/add', '\App\Http\Controllers\Admin\ClassController@add');
    Route::post('/admin/class/add', '\App\Http\Controllers\Admin\ClassController@addpost');
    Route::get('/admin/class/edit/{id}', '\App\Http\Controllers\Admin\ClassController@edit');
    Route::post('/admin/class/edit/{id}', '\App\Http\Controllers\Admin\ClassController@editpost');
    Route::get('/admin/class/del/{id}', '\App\Http\Controllers\Admin\ClassController@del');

    //文章模块
    Route::get('/admin/article/getData', '\App\Http\Controllers\Admin\ArticleController@getData');
    Route::get('/admin/article/getRubbishData', '\App\Http\Controllers\Admin\ArticleController@getRubbishData');
    Route::get('/admin/article/index/{cid?}', '\App\Http\Controllers\Admin\ArticleController@index');
    Route::get('/admin/article/rubbish', '\App\Http\Controllers\Admin\ArticleController@rubbish');
    Route::get('/admin/article/add', '\App\Http\Controllers\Admin\ArticleController@add');
    Route::post('/admin/article/add', '\App\Http\Controllers\Admin\ArticleController@addpost');
    Route::get('/admin/article/edit/{id}', '\App\Http\Controllers\Admin\ArticleController@edit');
    Route::post('/admin/article/edit/{id}', '\App\Http\Controllers\Admin\ArticleController@editpost');
    Route::get('/admin/article/recycle/{id}', '\App\Http\Controllers\Admin\ArticleController@recycle');
    Route::get('/admin/article/cancel/{id}', '\App\Http\Controllers\Admin\ArticleController@cancel');
    Route::get('/admin/article/publish/{id}', '\App\Http\Controllers\Admin\ArticleController@publish');
    Route::get('/admin/article/back/{id}', '\App\Http\Controllers\Admin\ArticleController@back');
    Route::get('/admin/article/del/{id}', '\App\Http\Controllers\Admin\ArticleController@del');

    //配置管理
    Route::get('/admin/config/getSystemData', '\App\Http\Controllers\Admin\ConfigController@getSystemData');
    Route::get('/admin/config/getExtendData', '\App\Http\Controllers\Admin\ConfigController@getExtendData');
    Route::get('/admin/config/system', '\App\Http\Controllers\Admin\ConfigController@system');
    Route::post('/admin/config/systemedit', '\App\Http\Controllers\Admin\ConfigController@systemedit');
    Route::get('/admin/config/extend', '\App\Http\Controllers\Admin\ConfigController@extend');
    Route::get('/admin/config/add', '\App\Http\Controllers\Admin\ConfigController@add');
    Route::post('/admin/config/add', '\App\Http\Controllers\Admin\ConfigController@addpost');
    Route::get('/admin/config/edit/{id}', '\App\Http\Controllers\Admin\ConfigController@edit');
    Route::post('/admin/config/edit/{id}', '\App\Http\Controllers\Admin\ConfigController@editpost');
    Route::get('/admin/config/del/{id}', '\App\Http\Controllers\Admin\ConfigController@del');

    //日志管理
    Route::get('/admin/log/getLoginData', '\App\Http\Controllers\Admin\LogController@getLoginData');
    Route::get('/admin/log/getOperateData', '\App\Http\Controllers\Admin\LogController@getOperateData');
    Route::get('/admin/log/loginlog', '\App\Http\Controllers\Admin\LogController@loginlog');
    Route::get('/admin/log/del/{id}', '\App\Http\Controllers\Admin\LogController@del');
    Route::get('/admin/log/operatelog', '\App\Http\Controllers\Admin\LogController@operatelog');
    Route::get('/admin/log/deloperate/{id}', '\App\Http\Controllers\Admin\LogController@deloperate');

});
