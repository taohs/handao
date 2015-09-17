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
     * 用户存在，替换密码，不存在，生成新用户
     * @param $mobile
     */
    function loginCodeAction()
    {
        $mobile = $this->request->getPost( 'mobile' );
        $user = $this->getUserByMobile($mobile);
        $smsComponent = new SmsComponent();
        if ($user) {
            $code = $this->getCode();
            $user->password = $this->security->hash($code);
            if ($user->save()) {
                $smsResult = $smsComponent->sendMessage($mobile, array($code),SmsComponent::LOGIN_CODE);
                echo json_encode($smsResult);
            }
        } else {
            $mobileValidator = new MobileValidator();
            if($mobileValidator->validate($mobile)){
                $code = $this->getCode();
                $HdUser = new HdUser();
                $HdUser->mobile = $mobile;
                $HdUser->username = $mobile;
                $HdUser->password = $this->security->hash( $code );
                $HdUser->update_time = date( "Y-m-d H:i:s" );
                $HdUser->create_time = date( "Y-m-d H:i:s" );
                if ($HdUser->save()) {
                    $smsResult = $smsComponent->sendMessage($mobile, array($code),SmsComponent::LOGIN_CODE);
                    echo json_encode($smsResult);
                }
            }else{
                echo json_encode(array('statusCode'=>10000,'statusMsg'=>'手机格式不正确'));
            }
        }
    }
    /**
     * 登录
     * @param null $mobile
     * @param null $code
     */
    function loginAction()
    {
        $mobile = $this->request->getPost( 'mobile' );
        $code = $this->request->getPost( 'code' );
        $user = $this->getUserByMobile($mobile);
        if ($user) {
            if($this->security->checkHash($code,$user->password)){
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