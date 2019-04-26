<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 17:07
 */

namespace app\api\service;


use app\api\model\ImgT;
use app\api\model\ServiceIndexT;
use app\lib\enum\CommonEnum;
use app\lib\exception\SaveException;

class IndexServices
{
    public function serviceIndex($params)
    {
        $params['state'] = CommonEnum::STATE_IS_OK;
        $params['logo'] = $this->getImageUrl($params['logo']);
        $res = ServiceIndexT::create($params);
        if (!$res) {
            throw new SaveException();
        }

    }


    public function getImageUrl($id)
    {
        $img = ImgT::where('id', $id)
            ->find();
        return $img->url;

    }

}