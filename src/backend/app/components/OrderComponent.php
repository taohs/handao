<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/30/15
 * Time: 21:57
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/30/15  Time: 21:57
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class OrderComponent extends \Phalcon\Mvc\User\Component
{
    const STATUS_NEW_CREATE = 11;
    const STATUS_NEW_CONFIRM = 12;
    const STATUS_RESULT_CANCEL = 30;
    const STATUS_RESULT_SUCCESS = 41;
    const STATUS_ASSIGN_PAYED = 21;
    const STATUS_ASSIGN_STAFF = 22;
    const STATUS_ASSIGN_SERVICE = 23;
    const STATUS_ASSIGN_FEEDBACK = 24;


    public $statusArray = array(
        self::STATUS_NEW_CREATE => '新建订单',
        self::STATUS_NEW_CONFIRM => '订单确认',
        self::STATUS_ASSIGN_PAYED => '订单支付',
        self::STATUS_ASSIGN_STAFF => '指派技师',
        self::STATUS_ASSIGN_SERVICE => '技师服务',
        self::STATUS_ASSIGN_FEEDBACK => '生成报告',
        self::STATUS_RESULT_CANCEL => '订单取消',
        self::STATUS_RESULT_SUCCESS => '订单完成',
    );

    public function createOrder($data){
        $fileLogger = new Phalcon\Logger\Adapter\File(APP_PATH.'/cache/interface.log');
        $fileLogger->log('request',json_encode($data));
        $apiUrl = $this->config->api->gateway . 'order/order';
        $response  = $this->restful->post($apiUrl,$data);
        $fileLogger->log('response',$response);
        return $response;
    }
}