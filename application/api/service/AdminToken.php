<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/5/19
 * Time: 18:27
 */

namespace app\api\service;


use app\api\model\AdminT;
use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;

class AdminToken extends Token
{
    protected $account;
    protected $pwd;


    function __construct($account, $pwd)
    {
        $this->account = $account;
        $this->pwd = $pwd;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        try {

            $admin = AdminT::where('account', '=', $this->account)
                ->find();

            if (is_null($admin)) {
                throw new TokenException([
                    'code' => 404,
                    'msg' => '用户不存在',
                    'errorCode' => 30000
                ]);
            }

            if (sha1($this->pwd) != $admin->passwd) {
                throw new TokenException([
                    'code' => 401,
                    'msg' => '密码不正确',
                    'errorCode' => 30002
                ]);
            }

            /**
             * 获取缓存参数
             */
            $cachedValue = $this->prepareCachedValue($admin);
            /**
             * 缓存数据
             */
            $token = $this->saveToCache('', $cachedValue);
            return $token;

        } catch (Exception $e) {
            throw $e;
        }

    }


    /**
     * @param $key
     * @param $cachedValue
     * @return mixed
     * @throws TokenException
     */
    private function saveToCache($key, $cachedValue)
    {
        $key = empty($key) ? self::generateToken() : $key;
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = Cache::remember($key, $value, $expire_in);


        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 20002
            ]);
        }

        $cachedValue['token'] = $key;
        unset($cachedValue['account']);
        return $cachedValue;
    }

    private function prepareCachedValue($admin)
    {

        $cachedValue = [
            'u_id' => $admin->id,
            'account' => $admin->account,
            'username' => $admin->username,
        ];

        return $cachedValue;
    }


}