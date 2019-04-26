<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 11:14
 */

namespace app\api\validate;


class Booking extends BaseValidate
{
    protected $rule = [
        'type' => 'require|isNotEmpty',
        'time' => 'require|isNotEmpty',
        'money' => 'require|isNotEmpty',
        'phone' => 'require|isMobile',
        'des' => 'require'
    ];
    protected $scene = [
        'save' => ['type', 'time','money','phone','des'],
    ];
}