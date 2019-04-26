<?php
/**
 * Created by PhpStorm.
 * User: zhumingliang
 * Date: 2018/3/20
 * Time: 下午2:00
 */

namespace app\api\validate;


class Token extends BaseValidate
{
    protected $rule = [
        'account' => 'require|isMobile',
        'passwd' => 'require|isNotEmpty'
    ];

    protected $message = [
        'account' => '获取Token，需要手机号',
        'passwd' => '获取Token，需要密码'
    ];

    protected $scene = [
        'getAdminToken' => ['account', 'pwd'],
    ];

}