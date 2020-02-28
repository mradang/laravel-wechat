<?php

namespace mradang\LaravelWechat\Services;

use Firebase\JWT\JWT;

class WeChatService
{
    public static function checkToken()
    {
        // 获取请求中的令牌
        $token = self::getTokenForRequest();
        if (empty($token)) {
            return false;
        }

        // 获取荷载中的用户id
        $tks = explode('.', $token);
        if (count($tks) !== 3) {
            return false;
        }
        $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($tks[1]));
        if (!$payload || !$payload->id) {
            return false;
        }

        // 读取用户
        $user = call_user_func(
            [config('mradang_laravel_wechat.user_model'), 'find'],
            $payload->id
        );
        if (empty($user)) {
            return false;
        }

        // 校验令牌
        try {
            $payload = JWT::decode($token, config('mradang_laravel_wechat.key'), array('HS256'));
            if ($payload) {
                return $user;
            }
        } catch (\Exception $e) {
            logger()->error('JWTException: '.$e->getMessage());
        }
        return false;
    }

    public static function makeToken($openid, $nickname, $avatar)
    {
        // 读取用户（新建用户）
        $user = call_user_func(
            [config('mradang_laravel_wechat.user_model'), 'wechatFirstOrCreate'],
            $openid,
            $nickname,
            $avatar
        );

        if (empty($user)) {
            return false;
        }

        $payload = $user->wechatTokenPload();
        $payload['exp'] = time() + config('mradang_laravel_wechat.ttl');
        return JWT::encode($payload, config('mradang_laravel_wechat.key'));
    }

    private static function getTokenForRequest()
    {
        $request = app()->request;
        $token = $request->input('api_token', $request->bearerToken());
        return $token;
    }
}
