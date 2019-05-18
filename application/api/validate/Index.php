<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 16:38
 */

namespace app\api\validate;


class Index extends BaseValidate
{
    protected $rule = [
        'name' => 'require',
        'des' => 'require',
        'c_id' => 'require|isPositiveInteger',
        'logo' => 'require|isPositiveInteger',
        'price' => 'require',
    ];
    protected $scene = [
        'category' => ['name', 'des'],
        'serviceIndex' => ['name', 'des', 'c_id', 'logo', 'price']
    ];

}