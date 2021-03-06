<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Token 有效期
    |--------------------------------------------------------------------------
    |
    | 指定 token 的有效时间（单位秒），默认 1 天（60*60*24=86400）
    |
    */
    'ttl' => env('LARAVEL_WECHAT_TOKEN_TTL', 86400),

    /*
    |--------------------------------------------------------------------------
    | Token key
    |--------------------------------------------------------------------------
    */
    'key' => env('LARAVEL_WECHAT_TOKEN_KEY'),

    /*
    |--------------------------------------------------------------------------
    | 允许前端站点
    |--------------------------------------------------------------------------
    |
    | 允许 JSAPI 签名的站点地址，多个站点用 | 分隔
    |
    */
    'sites' => env('LARAVEL_WECHAT_ALLOW_SITE', ''),

    /*
    |--------------------------------------------------------------------------
    | 微信用户模型
    |--------------------------------------------------------------------------
    */
    'user_model' => env('LARAVEL_WECHAT_USER_MODEL', \App\Models\User::class),

];
