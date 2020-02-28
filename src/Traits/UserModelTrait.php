<?php

namespace mradang\LaravelWechat\Traits;

trait UserModelTrait
{
    abstract protected static function wechatFirstOrCreate($openid, $nickname, $avatar);

    public function wechatTokenPload(): array
    {
        return [
            'id' => $this->id,
            'openid' => $this->openid,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
        ];
    }
}
