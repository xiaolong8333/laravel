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
    'namespace'  => 'App\Http\Controllers\Api\V1',
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
        'namespace'  => 'App\Http\Controllers\Api\V1',
        'middleware' => ['bindings','throttle:' . config('api.rate_limits.access')]], function ($api) {
        // 游客可以访问的接口
        $api->post('authorizations','AuthorizationsController@store')
            ->name('api.socials.authorizations.store');
        $api->post('weapp/authorizations', 'AuthorizationsController@weappStore')
            ->name('weapp.authorizations.store');
        // 某个用户的详情
        $api->get('users/{user}', 'UsersController@show')
            ->name('users.show');
        // 分类列表
        $api->get('categories','CategoriesController@index')
            ->name('categories.index');
        // 话题列表，详情
        $api->get('/topics','TopicsController@index')->name('topics.index');
        $api->get('/topics/{topic}', 'TopicsController@show')->name('topics.show');
        // 登录后可以访问的接口
        $api->group(['middleware' =>  'token.canrefresh'], function ($api) {
            $api->get('user', 'UsersController@me')
                ->name('user.show');
            // 刷新token
            $api->put('authorizations/current', 'AuthorizationsController@update')
                ->name('authorizations.update');
            // 删除token
            $api->delete('authorizations/current', 'AuthorizationsController@destroy')
                ->name('authorizations.destroy');
            // 上传图片
            $api->post('images', 'ImagesController@store')
                ->name('images.store');
            // 发布话题
            $api->post('/topics', 'TopicsController@store')->name('topics.store');
            //修改话题
            $api->patch('/topics/{topic}', 'TopicsController@update')->name('topics.update');
            //删除话题
            $api->delete('/topics/{topic}', 'TopicsController@destroy')->name('topics.destroy');
            //创建回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('topics.replies.store');
            //删除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('topics.replies.destroy');
            //某个话题的回复列表
            $api->get('topics/{topic}/replies', 'RepliesController@index')
                ->name('topics.replies.index');
            //某个用户的回复列表
            $api->get('users/{user}/replies', 'RepliesController@userIndex')
                ->name('users.replies.index');
            //通知列表
            $api->get('notifications', 'NotificationsController@index')
                ->name('notifications.index');
            //通知统计
            $api->get('notifications/stats', 'NotificationsController@stats')
                ->name('notifications.stats');
            //标记消息通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('user.notifications.read');
       });
});
