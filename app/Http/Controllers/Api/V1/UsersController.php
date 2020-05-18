<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if(!$verifyData) {
            abort(403,'验证码已失效');
        }

        if(!hash_equals($verifyData['code'],$request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);
        return new UserResource($user);
    }

    public function show(User $user)
    {
        //$user = User::where('id', $user)->first();
        return new UserResource($user);
    }

    public function me(Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }
}
