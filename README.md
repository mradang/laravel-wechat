## 安装

```shell
$ composer require mradang/laravel-wechat -vvv
```

### 可选项

1. 发布配置文件

```shell
$ php artisan vendor:publish --provider="mradang\\LaravelWechat\\LaravelWechatServiceProvider"
```

## 配置

1. 添加 .env 环境变量，使用默认值时可省略
```
# 指定 token 的有效时间（单位秒），默认 24 小时（60*60*24=86400）
LARAVEL_WECHAT_TOKEN_TTL=86400
# 生成 token 使用的秘钥
LARAVEL_WECHAT_TOKEN_KEY=
# 允许的前端站点，多个站点用 | 分隔
LARAVEL_WECHAT_ALLOW_SITE=http://localhost
# 指定用户模型类，实现认证的关键配置
LARAVEL_WECHAT_USER_MODEL=\App\Models\User
```

## 添加的内容

### 添加的路由
- post /api/extra/wechat/login 获取微信认证地址
- get /api/extra/wechat/auth 根据用户 code 认证微信用户
- post /api/extra/wechat/config 客户端 JSAPI 配置

### 添加的路由中间件
1. wechat 微信认证

## 微信认证功能

### 模型 Trait
```php
use mradang\LaravelWechat\Traits\UserModelTrait;
```

模型必须实现以下函数，返回用户 Model
```php
static function wechatFirstOrCreate($openid, $nickname, $avatar);
```

模型可根据字段情况实现以下函数，返回值为数组，必须有 id 字段，其他字段选填
```php
function wechatTokenPload(): array
```
