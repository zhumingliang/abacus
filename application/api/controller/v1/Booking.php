<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019-04-26
 * Time: 11:12
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\BookingT;
use app\lib\enum\CommonEnum;
use app\lib\exception\SaveException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UpdateException;

class Booking extends BaseController
{
    /**
     * @api {POST} /api/v1/booking  3-新增预约
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  官网新增预约请求
     * @apiExample {post}  请求样例:
     *    {
     *       "type": "税收服务"
     *       "time": 2019-04-29 10:00
     *       "money": "1000-2000"
     *       "phone": 18956225230
     *       "des":"了解"
     *     }
     * @apiParam (请求参数说明) {String} type   服务类型
     * @apiParam (请求参数说明) {String} time    预约时间
     * @apiParam (请求参数说明) {String} money  预算多少
     * @apiParam (请求参数说明) {String} phone   联系方式
     * @apiParam (请求参数说明) {String} des    备注
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
        $res = BookingT::create($params);
        if (!$res) {
            throw new SaveException();
        }
        return json(new SuccessMessage());
    }

    /**
     * @api {GET} /api/v1/bookings 4-获取预约列表
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  后台管理获取预约列表
     * @apiExample {get} 请求样例:
     * http://abacus.mengant.cn/api/v1/bookings?page=1&size=10
     * @apiParam (请求参数说明) {int}  page 页码
     * @apiParam (请求参数说明) {int}  size 页数
     * @apiSuccessExample {json} 返回样例:
     * {"total":3,"per_page":"10","current_page":1,"last_page":1,"data":[{"id":5,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:47:07","update_time":"2019-04-26 11:47:09"},{"id":4,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:47:02","update_time":"2019-04-26 11:47:04"},{"id":1,"type":"税收服务","time":"2019-04-29 10:00","money":"1000-2000","phone":"18956225230","des":"了解","state":1,"create_time":"2019-04-26 11:46:54","update_time":"2019-04-26 11:46:58"}]}
     * @apiSuccess (返回参数说明) {int} total 数据总数
     * @apiSuccess (返回参数说明) {int} per_page 每页多少条数据
     * @apiSuccess (返回参数说明) {int} current_page 当前页码
     * @apiSuccess (返回参数说明) {String} type   服务类型
     * @apiSuccess (返回参数说明) {String} time    预约时间
     * @apiSuccess (返回参数说明) {String} money  预算多少
     * @apiSuccess (返回参数说明) {String} phone   联系方式
     * @apiSuccess (返回参数说明) {String} des    备注
     * @param $page
     * @param $size
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function bookings($page = 1, $size = 10)
    {
        $pagingData = BookingT::order('state,create_time desc')
            ->paginate($size, false, ['page' => $page])->toArray();

        return json($pagingData);
    }

    /**
     * @api {POST} /api/v1/booking/handel  5-预约订单状态操作
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  管理员确认操作预约订单
     * @apiExample {POST}  请求样例:
     * {
     * "id": 1
     * }
     * @apiParam (请求参数说明) {int} id  预约订单id
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
        $res = BookingT::update(['state' => CommonEnum::STATE_IS_FAIL], ['id' => $id]);
        if (!$res) {
            throw new UpdateException();
        }

        return json(new SuccessMessage());
    }

}