<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/6/15
 * Time: 15:53
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/6/15  Time: 15:53
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class SmsController extends ControllerBase
{
    //sdk 对象
    /**
     * @var SmsComponent
     */
    protected $smsComponent;



    function onConstruct()
    {
        parent::onConstruct();
        $this->smsComponent = new SmsComponent();
    }


    function sendMessageAction($mobile=null, $content=null)
    {
        $mobileValidator = new MobileValidator();
        if($mobileValidator->validate($mobile) && !is_null($content))
        {
            $result = $this->smsComponent->sendMessage($mobile,$content);
        }else{
            $result = array('statusCode'=>'-1','statusMsg'=>'发送失败');
        }
        var_dump($result);
        echo json_encode($result);
    }


    public function getSdk()
    {
        $this->smsComponent = new SmsComponent();

        $this->sdk = new CCPRestSDK($this->sdkIp, $this->sdkPort, $this->sdkVersion);
        $this->sdk->setAccount($this->accountSid,$this->accountToken);
        $this->sdk->setAppId($this->applicationId);
    }
}