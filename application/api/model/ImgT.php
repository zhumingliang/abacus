<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 17:04
 */

namespace app\api\model;

class ImgT extends BaseModel
{
    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}