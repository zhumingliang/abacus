<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 11:10
 */

namespace app\api\model;


use think\Model;

class ServiceCategoryT extends Model
{
    public function services()
    {
        return $this->hasMany('ServiceIndexT',
            'c_id', 'id');
    }

}