<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/6/15
 * Time: 23:43
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/6/15  Time: 23:43
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class SmsComponent extends \Phalcon\Mvc\User\Component
{
    //sdk 对象
    /**
     * @var CCPRestSDK
     */
    protected $sdk;

    //主帐号,对应开官网发者主账号下的 ACCOUNT SID
    protected $accountSid = 'aaf98f894fa5766f014fa5d222570088';// '8a48b5514f73ea32014fa0a0ae385509';

    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    protected $accountToken = '55d5bb04fbc64659ad53db983b7faa71';//'fd33e76a4191408fac2d5b0d9835b59d';

    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    protected $applicationId = 'aaf98f894fa5766f014fa67028f5013b';//'8a48b5514f73ea32014fa0a0e8e5550c';


    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    protected $sdkIp = 'sandboxapp.cloopen.com';

    //请求端口，生产环境和沙盒环境一致
    protected $sdkPort = '8883';

    //REST版本号，在官网文档REST介绍中获得。
    protected $sdkVersion = '2013-12-26';



    function __construct()
    {
        $this->getSdk();
    }


    function sendMessage($mobile=null, $content=null)
    {
        return  $this->sdk->sendTemplateSMS($mobile,array($content,'3'),1);
    }


    public function getSdk()
    {
        $this->sdk = new CCPRestSDK($this->sdkIp, $this->sdkPort, $this->sdkVersion);
        $this->sdk->setAccount($this->accountSid,$this->accountToken);
        $this->sdk->setAppId($this->applicationId);
    }
}