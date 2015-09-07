<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/6/15
 * Time: 23:26
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/6/15  Time: 23:26
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class UserController extends ControllerBase
{

    /**
     * 获取登录验证码
     * @param $mobile
     */
    function loginCodeAction($mobile=null)
    {
        $user = $this->getUserByMobile($mobile);

        if ($user) {
            $code = $this->getCode();

            $user->password = $this->security->hash($code);
            if ($user->save()) {
                $smsComponent = new SmsComponent();
                $smsResult = $smsComponent->sendMessage($mobile, $code);
                echo json_encode($smsResult);
            }
        } else {
            echo json_encode(array('statusCode' => '1000', 'statusMsg' => '用户不存在'));
        }
    }

    /**
     * 登录
     * @param null $mobile
     * @param null $code
     */
    function loginAction($mobile=null, $code=null)
    {
        $user = $this->getUserByMobile($mobile);
        if ($user) {
            if(!$this->security->checkHash($code,$user->password)){
                //登录成功
                 echo $json = json_encode(array('statusCode' => '000000', 'statusMsg' => '登录成功','content'=>$user));
            }else{
                echo json_encode(array('statusCode' => '1000000', 'statusMsg' => '登录失败'));
            }
        } else {
            echo json_encode(array('statusCode' => '1000', 'statusMsg' => '用户不存在'));
        }
    }

    function orderAction($mobile,$page){

    }


}