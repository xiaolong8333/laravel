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

$api = app('Dingo\Api\Routing\Router');

$api->group([
    'version' => 'v1',
    'namespace'  => 'App\Http\Controllers\Api',
    'middleware' => ['bindings','throttle:' . config('api.rate_limits.sign')]],function ($api) {

        $api->get('index', 'IndexController@show');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('users.store');
        $api->post('verificationCodes',
            'VerificationCodesController@store')
            ->name('verificationCodes.store');
    });

    $api->group([
        'version' => 'v1',
        'namespace'  => 'App\Http\Controllers\Api',
        'middleware' => ['bindings','throttle:' . config('api.rate_limits.access')]], function ($api) {
            // 游客可以访问的接口
        $api->post('authorizations','AuthorizationsController@store')
            ->name('api.socials.authorizations.store');
        $api->get('users/{user}', 'UsersController@show')
            ->name('users.show');
        // 登录后可以访问的接口
        $api->group(['middleware' =>  'auth'], function ($api) {
            $api->get('user', 'UsersController@me')
                ->name('user.show');
            // 刷新token
            $api->put('authorizations/current', 'AuthorizationsController@update')
                ->name('authorizations.update');
            // 删除token
            $api->delete('authorizations/current', 'AuthorizationsController@destroy')
                ->name('authorizations.destroy');
            // 登录后可以访问的接口

            // 上传图片
            $api->post('images', 'ImagesController@store')
                ->name('images.store');
       });
});

/*
$api->group([
    'version' => 'v1',
    'namespace'  => 'App\Http\Controllers\Api',
    'middleware' => ['bindings','throttle:' . config('api.rate_limits.sign')]],function ($api) {

    $api->get('index', 'IndexController@show');
    // 用户注册
    $api->post('users', 'UsersController@store')
        ->name('users.store');
    $api->post('verificationCodes',
        'VerificationCodesController@store')
        ->name('verificationCodes.store');
});

$api->group([
    'version' => 'v1',
    'namespace'  => 'App\Http\Controllers\Api',
    'middleware' => ['bindings','throttle:' . config('api.rate_limits.access')], function ($api) {
        // 游客可以访问的接口
        $api->post('authorizations','AuthorizationsController@store')
            ->name('api.socials.authorizations.store');
        $api->get('users/{user}', 'UsersController@show')
            ->name('users.show');
        // 登录后可以访问的接口
        $api->group(['middleware' =>  'auth:api'], function ($api) {
            $api->get('user', 'UsersController@me')
                ->name('user.show');
            // 刷新token
            $api->put('authorizations/current', 'AuthorizationsController@update')
                ->name('authorizations.update');
            // 删除token
            $api->delete('authorizations/current', 'AuthorizationsController@destroy')
                ->name('authorizations.destroy');
        });
    });*/