<?php

namespace mradang\LaravelWechat;

use Illuminate\Support\ServiceProvider;

class LaravelWechatServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../config/config.php'), 'mradang_laravel_wechat');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
    }
}
