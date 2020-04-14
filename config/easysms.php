<?php
/**
 * Created by PhpStorm.
 * User: zyiwt
 * Date: 2020/4/13 0013
 * Time: 11:12
 */
return [
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
            ],
        'aliyun' => [
            'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
            'sign_name' => 'Larabbs',
            'templates' => [
                'register' => env('SMS_ALIYUN_TEMPLATE_REGISTER'),
            ],
        ],
    ]
    ];