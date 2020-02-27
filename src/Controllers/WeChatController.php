<?php

namespace mradang\LaravelWechat\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use mradang\LaravelWechat\Services\WeChatService;

class WeChatController extends BaseController
{
    // 获取微信认证地址
    public function login(Request $request)
    {
        $this->validate($request, [
            'scopes' => 'required|string|in:snsapi_base,snsapi_userinfo',
            'url' => 'required|url',
        ]);

        $scopes = [$request->scopes];

        $officialAccount = app('wechat.official_account.default');
        return $officialAccount
            ->oauth
            ->scopes($scopes)
            ->redirect($request->url)
            ->getTargetUrl();
    }

    // 根据用户 code 认证微信用户
    public function auth()
    {
        $officialAccount = app('wechat.official_account.default');

        // https://www.easywechat.com/docs/4.1/official-account/oauth#heading-h3-6
        $user = $officialAccount->oauth->user();

        $user = [
            'id' => $user->id,
            'openid' => $user->getId(),
            'nickname' => $user->getNickname(),
            'avatar' => $user->getAvatar(),
        ];
        return WeChatService::makeToken($user);
    }

    // 客户端 JSAPI 配置
    public function config(Request $request)
    {
        $validatedData = $this->validate($request, [
            'url' => 'required|url',
            'apis' => 'required|array',
            'debug' => 'boolean',
        ]);

        $officialAccount = app('wechat.official_account.default');
        $officialAccount->jssdk->setUrl($request->url);

        return $officialAccount->jssdk->buildConfig(
            $validatedData['apis'],
            $request->input('debug', false),
            false,
            false
        );
    }
}
