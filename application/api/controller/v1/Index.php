<?php

namespace app\api\controller\v1;

use app\api\model\ServiceCategoryT;
use app\api\model\ServiceIndexT;
use app\api\service\IndexServices;
use app\lib\enum\CommonEnum;
use app\lib\exception\DeleteException;
use app\lib\exception\SaveException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UpdateException;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        echo 'success';
    }

    /**
     * @api {POST} /api/v1/category  6-新增首页轮播服务类别
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  新增首页轮播服务类别
     * @apiExample {post}  请求样例:
     *    {
     *       "name": "工商注册",
     *       "des":"极速响应,中国领先的会计服务平台,专属顾问一对一服务,价格透明，无隐藏收费"
     *     }
     * @apiParam (请求参数说明) {String} name   服务类型
     * @apiParam (请求参数说明) {String} des    描述
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @return \think\response\Json
     * @throws SaveException
     */
    public function category()
    {
        $params = $this->request->param();
        $params['state'] = CommonEnum::STATE_IS_OK;
        $res = ServiceCategoryT::create($params);
        if (!$res) {
            throw  new SaveException();
        }
        return json(new SuccessMessage());
    }

    /**
     * @api {POST} /api/v1/category/update  20-修改首页轮播服务类别
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  新增首页轮播服务类别
     * @apiExample {post}  请求样例:
     *    {
     *       "id": 1,
     *       "name": "工商注册",
     *       "des":"极速响应,中国领先的会计服务平台,专属顾问一对一服务,价格透明，无隐藏收费"
     *     }
     * @apiParam (请求参数说明) {String} name   服务类型
     * @apiParam (请求参数说明) {String} des    描述
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @return \think\response\Json
     * @throws UpdateException
     */
    public function categoryUpdate()
    {
        $params = $this->request->param();
        $res = ServiceCategoryT::update($params,['id',$params['id']]);
        if (!$res) {
            throw  new UpdateException();
        }
        return json(new SuccessMessage());
    }

    /**
     * @api {GET} /api/v1/categories 7-获取首页配置服务列表
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  获取首页配置服务列表
     * @apiExample {get} 请求样例:
     * http://api.tdjsp.cn/api/v1/categories
     * @apiSuccessExample {json} 返回样例:
     * [{"id":1,"name":"工商注册","des":"极速响应,中国领先的会计服务平台,专属顾问一对一服务,价格透明，无隐藏收费","services":[{"id":1,"logo":"http:\/\/a.png","name":"注册公司","des":"0 元快速注册 周期短，费用低 \n拒绝隐形消费 一对一专属服务","c_id":1,"price":2580}]}]
     * @apiSuccess (返回参数说明) {int} id 类别id
     * @apiSuccess (返回参数说明) {String} name 类别名称
     * @apiSuccess (返回参数说明) {String} des    类别描述
     * @apiSuccess (返回参数说明) {OBJ} services   服务信息
     * @apiSuccess (返回参数说明) {int} id    服务id
     * @apiSuccess (返回参数说明) {String} logo  logo地址
     * @apiSuccess (返回参数说明) {String} name   服务名称
     * @apiSuccess (返回参数说明) {String} des   描述
     * @apiSuccess (返回参数说明) {int} price   价格
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function categories()
    {
        $list = ServiceCategoryT::where('state', CommonEnum::STATE_IS_OK)
            ->with(['services' => function ($query) {
                $query->where('state', '=', CommonEnum::STATE_IS_OK)
                    ->field('id,logo,name,des,c_id,price');
            }])
            ->field('id,name,des')
            ->select();
        return json($list);

    }

    /**
     * @api {POST} /api/v1/service  8-新增服务类别下的服务
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  新增服务类别下的服务
     * @apiExample {post}  请求样例:
     *    {
     *       "name": "注册公司",
     *       "des":"0 元快速注册 周期短，费用低拒绝隐形消费 一对一专属服务",
     *       "logo":1,
     *       "c_id":1,
     *       "price":2580,
     *     }
     * @apiParam (请求参数说明) {String} name   服务类型
     * @apiParam (请求参数说明) {String} des    描述
     * @apiParam (请求参数说明) {int} logo    logoID,由新增图片接口返回
     * @apiParam (请求参数说明) {int} c_id    分类id
     * @apiParam (请求参数说明) {int} price    价格
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @return \think\response\Json
     * @throws SaveException
     */
    public function serviceIndex()
    {
        $params = $this->request->param();
        (new IndexServices())->serviceIndex($params);
        return json(new SuccessMessage());

    }

    /**
     * @api {POST} /api/v1/service/handel  10-首页服务状态操作/删除
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  首页服务状态操作/删除
     * @apiExample {POST}  请求样例:
     * {
     * "id": 1
     * }
     * @apiParam (请求参数说明) {int} id  服务id
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} error_code 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @param $id
     * @return \think\response\Json
     * @throws DeleteException
     */
    public function serviceHandel($id)
    {
        $res = ServiceIndexT::update(['state' => CommonEnum::STATE_IS_FAIL], ['id' => $id]);
        if (!$res) {
            throw new DeleteException();
        }

        return json(new SuccessMessage());
    }


    /**
     * @api {POST} /api/v1/service/update  19-修改服务
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  修改服务
     * @apiExample {post}  请求样例:
     *    {
     *       "id": "注册公司",
     *       "name": "注册公司",
     *       "des":"0 元快速注册 周期短，费用低拒绝隐形消费 一对一专属服务",
     *       "logo":1,
     *       "c_id":1,
     *       "price":2580,
     *     }
     * @apiParam (请求参数说明) {String} name   服务类型
     * @apiParam (请求参数说明) {String} des    描述
     * @apiParam (请求参数说明) {int} logo    logoID,由新增图片接口返回
     * @apiParam (请求参数说明) {int} c_id    分类id
     * @apiParam (请求参数说明) {int} price    价格
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @return \think\response\Json
     * @throws SaveException
     */
    public function serviceUpdate()
    {
        $params = $this->request->param();
        (new IndexServices())->serviceUpdate($params);
        return json(new SuccessMessage());

    }

}
