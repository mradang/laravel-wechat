<?php

namespace mradang\LaravelWechat\Services;

use Firebase\JWT\JWT;

class WeChatService
{
    public static function user()
    {
        $user = self::parseToken();
        if (!$user) {
            throw new \Exception('用户未认证');
        }
        return $user;
    }

    public static function parseToken($token = null)
    {
        $token = $token ?? self::getTokenForRequest();
        if (empty($token)) {
            return false;
        }

        try {
            if ($payload = JWT::decode($token, config('mradang_laravel_wechat.key'), array('HS256'))) {
                return $payload;
            }
        } catch (\Exception $e) {
            info('JWTException: ' . $e->getMessage());
        }
        return false;
    }

    public static function makeToken(array $payload)
    {
        $payload['exp'] = time() + 86400;
        return JWT::encode($payload, config('mradang_laravel_wechat.key'));
    }

    private static function getTokenForRequest()
    {
        $request = app()->request;
        $token = $request->input('api_token', $request->bearerToken());
        return $token;
    }
}
