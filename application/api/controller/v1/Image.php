<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 17:03
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\ImgT;
use app\lib\enum\CommonEnum;
use app\lib\exception\SaveException;

class Image extends BaseController
{
    /**
     * @param $img
     * @return \think\response\Json
     * @throws SaveException
     * @api {POST} /api/v1/image  9-图片上传
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription
     * @apiExample {post}  请求样例:
     *    {
     *       "img": "4f4bc4dec97d474b"
     *     }
     * @apiParam (请求参数说明) {String} img    图片base64位编码
     *
     * @apiSuccessExample {json} 返回样例:
     *{"id":17}
     * @apiSuccess (返回参数说明) {int} id 图片id
     *
     */
    public function save($img)
    {
        $param['url'] = base64toImg($img);
        $param['state'] = CommonEnum::STATE_IS_OK;
        $obj = ImgT::create($param);
        if (!$obj) {
            throw new SaveException();
        }
        return json(['id' => $obj->id]);

    }


    /**
     * @api {POST} /api/v1/image  22-图片上传返回url
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription
     * @apiExample {post}  请求样例:
     *    {
     *       "img": "4f4bc4dec97d474b"
     *     }
     * @apiParam (请求参数说明) {String} img    图片base64位编码
     *
     * @apiSuccessExample {json} 返回样例:
     *{"url":http://api.tdjsp.cn/a.png}
     * @apiSuccess (返回参数说明) {int} id 图片id
     *
     */
    public function saveToUrl($img)
    {
        $param['url'] = base64toImg($img);
        $param['state'] = CommonEnum::STATE_IS_OK;
        $obj = ImgT::create($param);
        if (!$obj) {
            throw new SaveException();
        }
        return json(['url' => config('setting.img_prefix') . $param['url']]);

    }


}