<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 23:01
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\ApplyT;
use app\lib\enum\CommonEnum;
use app\lib\exception\SaveException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UpdateException;

class Apply extends BaseController
{
    /**
     * @api {POST} /api/v1/apply  11-新增申请
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  官网新增预约请求
     * @apiExample {post}  请求样例:
     *    {
     *       "username": "张三"
     *       "phone": 18956225230,
     *       "type":1,
     *       "name":"金算盘"
     *     }
     * @apiParam (请求参数说明) {String} username   申请人名称
     * @apiParam (请求参数说明) {String} phone    手机号
     * @apiParam (请求参数说明) {int} type  申请类别：申请类别：1 | 企业名称查询表；2 | 获取注册公司报价; 3 | 获取代理记账及方案；4 | 立即带账；5 | 商标注册获取报价
     * @apiParam (请求参数说明) {String} name   企业名称（type=1 时需要出传入）
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} errorCode 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @return \think\response\Json
     * @throws SaveException
     */
    public function save()
    {
        $params = $this->request->param();
        $params['state'] = CommonEnum::STATE_IS_OK;
        $res = ApplyT::create($params);
        if (!$res) {
            throw new SaveException();
        }
        return json(new SuccessMessage());
    }


    /**
     * @api {GET} /api/v1/applies 12-获取申请列表
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  获取申请列表
     * @apiExample {get} 请求样例:
     * http://abacus.mengant.cn/api/v1/applies?page=1&size=10&type=9
     * @apiParam (请求参数说明) {int}  page 页码
     * @apiParam (请求参数说明) {int}  size 页数
     * @apiParam (请求参数说明) {int}  type 申请类别：9 | 获取全部； 1 | 企业名称查询表；2 | 获取注册公司报价; 3 | 获取代理记账及方案；4 | 立即带账；5 | 商标注册获取报价
     * @apiSuccessExample {json} 返回样例:
     * {"total":3,"per_page":"10","current_page":1,"last_page":1,"data":[{"id":5,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:47:07","update_time":"2019-04-26 11:47:09"},{"id":4,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:47:02","update_time":"2019-04-26 11:47:04"},{"id":1,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:46:54","update_time":"2019-04-26 11:46:58"}]}
     * @apiSuccess (返回参数说明) {int} total 数据总数
     * @apiSuccess (返回参数说明) {int} per_page 每页多少条数据
     * @apiSuccess (返回参数说明) {int} current_page 当前页码
     * @apiSuccess (返回参数说明) {String} username   申请人名称
     * @apiSuccess (返回参数说明) {String} phone    手机号
     * @apiSuccess (返回参数说明) {int} type  申请类别：申请类别：1 | 企业名称查询表；2 | 获取注册公司报价; 3 | 获取代理记账及方案；4 | 立即带账；5 | 商标注册获取报价
     * @apiSuccess (返回参数说明) {String} name   企业名称（type=1 时返回）
     * @param int $type
     * @param int $page
     * @param int $size
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function applies($type = 9, $page = 1, $size = 10)
    {
        $pagingData = ApplyT::where(function ($query) use ($type) {
            if ($type != 9) {
                $query->where('type', '=', $type);
            }
        })
            ->order('state,create_time desc')
            ->paginate($size, false, ['page' => $page])->toArray();

        return json($pagingData);

    }


    /**
     * @api {POST} /api/v1/apply/handel  13-申请状态操作
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  管理员申请状态操作
     * @apiExample {POST}  请求样例:
     * {
     * "id": 1
     * }
     * @apiParam (请求参数说明) {int} id  申请id
     * @apiSuccessExample {json} 返回样例:
     * {"msg": "ok","error_code": 0}
     * @apiSuccess (返回参数说明) {int} error_code 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     * @param $id
     * @return \think\response\Json
     * @throws UpdateException
     */
    public function handel($id)
    {
        $res = ApplyT::update(['state' => CommonEnum::STATE_IS_FAIL], ['id' => $id]);
        if (!$res) {
            throw new UpdateException();

        }
        return json(new SuccessMessage());
    }



}