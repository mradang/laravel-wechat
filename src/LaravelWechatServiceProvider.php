<?php

namespace mradang\LaravelWechat;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class LaravelWechatServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../config/config.php'), 'mradang_laravel_wechat');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');

        Auth::viaRequest('wechat-token', function () {
            $user = Services\WeChatService::checkToken();
            return $user ?: null;
        });

        // 认证中间件
        $this->app->router->aliasMiddleware('wechat', Middleware\Authenticate::class);

        // 修改全局认证配置
        $auth = [
            'guards' => [
                'wechat' => [
                    'driver' => 'wechat-token',
                    'provider' => 'wechat',
                    'hash' => false,
                ]
            ],
        ];
        config(Arr::dot($auth, 'auth.'));
    }
}
