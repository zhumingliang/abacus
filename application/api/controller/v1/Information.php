<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\InfoT;
use app\api\service\IndexServices;
use app\lib\enum\CommonEnum;
use app\lib\exception\SaveException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UpdateException;

class Information extends BaseController
{
    /**
     * @api {POST} /api/v1/information/save  14-新增资讯
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  管理后台新增资讯
     * @apiExample {post}  请求样例:
     *    {
     *       "title": "注意！安徽全面推行企业登记身份管理实名验证！",
     *       "header_url": 1,
     *       "content": "为有效遏制冒用他人身份证信息"
     *     }
     * @apiParam (请求参数说明) {String} title   资讯标题
     * @apiParam (请求参数说明) {String} header_url    封面图图片id：通过图片上传接口上传返回id
     * @apiParam (请求参数说明) {String} content  内容
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     */
    public function save()
    {
        $params = $this->request->param();
        $params['state'] = CommonEnum::STATE_IS_OK;
        if (key_exists('header_url', $params) && strlen($params['header_url'])) {
            $params['header_url'] = (new  IndexServices())->getImageUrl($params['header_url']);
        }
        $res = InfoT::create($params);
        if (!$res) {
            throw new SaveException();
        }
        return json(new SuccessMessage());
    }


    /**
     * @api {POST} /api/v1/information/update  15-修改资讯
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  管理后台新增资讯
     * @apiExample {post}  请求样例:
     *    {
     *       "id": 1,
     *       "title": "注意！安徽全面推行企业登记身份管理实名验证！",
     *       "header_url": 1,
     *       "content": "为有效遏制冒用他人身份证信息"
     *     }
     * @apiParam (请求参数说明) {int} id   ID
     * @apiParam (请求参数说明) {String} title   资讯标题
     * @apiParam (请求参数说明) {String} header_url    封面图图片id：通过图片上传接口上传返回id
     * @apiParam (请求参数说明) {String} content  内容
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     */
    public function update()
    {
        $params = $this->request->param();
        if (key_exists('header_url', $params) && strlen($params['header_url'])) {
            $params['header_url'] = (new  IndexServices())->getImageUrl($params['header_url']);
        }
        $res = InfoT::update($params);
        if (!$res) {
            throw new SaveException();
        }
        return json(new SuccessMessage());
    }


    /**
     * @api {GET} /api/v1/informations 16-获取资讯列表
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  官网/后台管理获取资讯列表
     * @apiExample {get} 请求样例:
     * http://api.tdjsp.cn/api/v1/informations?page=1&size=10
     * @apiParam (请求参数说明) {int}  page 页码
     * @apiParam (请求参数说明) {int}  size 页数
     * @apiSuccessExample {json} 返回样例:
     * {"total":1,"per_page":"10","current_page":1,"last_page":1,"data":[{"id":1,"title":"税收服务","header_url":"http://a.png","content":"内容","create_time":"2019-04-26 11:47:07","update_time":"2019-04-26 11:47:09"}]}
     * @apiSuccess (返回参数说明) {int} total 数据总数
     * @apiSuccess (返回参数说明) {int} per_page 每页多少条数据
     * @apiSuccess (返回参数说明) {int} current_page 当前页码
     * @apiSuccess (返回参数说明) {int} id   ID
     * @apiSuccess (返回参数说明) {String} title   资讯标题
     * @apiSuccess (返回参数说明) {String} header_url    封面图图片id：通过图片上传接口上传返回id
     * @apiSuccess (返回参数说明) {String} content  内容
     * @apiSuccess (返回参数说明) {String} create_time  创建时间
     */
    public function informations($page = 1, $size = 10)
    {
        $pagingData = InfoT::order('create_time desc')
            ->where('state', CommonEnum::STATE_IS_OK)
            ->paginate($size, false, ['page' => $page])->toArray();

        return json($pagingData);
    }



    /**
     * @api {GET} /api/v1/information 18-获取指定资讯
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  官网/后台管理获取资讯列表
     * @apiExample {get} 请求样例:
     * http://api.tdjsp.cn/api/v1/information?id=1
     * @apiParam (请求参数说明) {int}  id  资讯id
     * @apiSuccessExample {json} 返回样例:
     * {"id":1,"title":"税收服务","header_url":"http://a.png","content":"内容","create_time":"2019-04-26 11:47:07","update_time":"2019-04-26 11:47:09"}
     * @apiSuccess (返回参数说明) {int} id   ID
     * @apiSuccess (返回参数说明) {String} title   资讯标题
     * @apiSuccess (返回参数说明) {String} header_url  封面图
     * @apiSuccess (返回参数说明) {String} content  内容
     * @apiSuccess (返回参数说明) {String} create_time  创建时间
     */
    public function information($id)
    {
        $info = InfoT::where('id', $id)
            ->find();

        return json($info);
    }

    /**
     * @api {POST} /api/v1/information/handel  17-资讯状态操作
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  资讯状态操作
     * @apiExample {POST}  请求样例:
     * {
     * "id": 1
     * }
     * @apiParam (请求参数说明) {int} id  预约订单id
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} error_code 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     */
    public function handel($id)
    {
        $res = InfoT::update(['state' => CommonEnum::STATE_IS_FAIL], ['id' => $id]);
        if (!$res) {
            throw new UpdateException();
        }

        return json(new SuccessMessage());
    }


}