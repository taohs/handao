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

    function editLinkInfo(){

        /**
         * 新加入过滤
         */

        $modelsExact_id = $this->request->getPost('modelsExact_id');
        $mobile = $this->request->getPost('mobile', \Phalcon\Filter::FILTER_FLOAT);
        $captcha = $this->request->getPost('captcha', \Phalcon\Filter::FILTER_FLOAT);

        $name = $this->request->getPost('name', \Phalcon\Filter::FILTER_STRING);
        $address = $this->request->getPost('address', \Phalcon\Filter::FILTER_STRING);
        $carnum = $this->request->getPost('carnum', \Phalcon\Filter::FILTER_STRING);

        $origin = $this->request->getPost('origin', \Phalcon\Filter::FILTER_STRING);


        $fileLogger = new Phalcon\Logger\Adapter\File(APP_PATH . '/cache/post.log');
        $fileLogger->log(Phalcon\Logger::INFO, json_encode($_POST));
        //filter the origin;
        if (!in_array($origin, array(self::ORIGIN_PORTAL, self::ORIGIN_API, self::ORIGIN_MOBILE, self::ORIGIN_BACKEND))) {
            $origin = self::ORIGIN_PORTAL;
        }

        //todo 没有做 提交空信息处理；；
        //todo 没有过滤手机号码；
        //todo 大爷的，通宵改bug；；

        if (!preg_match('/^1[3-9]{1}[0-9]{9}$/', $mobile)) {
            return $this->responseJson(self::PARAMS_ERROR_CODE, "手机格式不正确");
        }
        if ($origin == self::ORIGIN_PORTAL) {
            if (!preg_match('/^[0-9]{4}$/', $captcha)) {
                return $this->responseJson(self::PARAMS_ERROR_CODE, "手机验证码格式不正确");
            }
        }

        if (empty($name)) {
            return $this->responseJson(self::PARAMS_ERROR_CODE, "姓名不能为空");
        }
        if (empty($address)) {
            return $this->responseJson(self::PARAMS_ERROR_CODE, "地址不能为空");
        }
        if (empty($carnum)) {
            return $this->responseJson(self::PARAMS_ERROR_CODE, "车牌号不能为空");
        }

        $userComponent = new UserComponent();
        if ($mobile) {
            $user = $userComponent->getUser($mobile);

            if (empty($user) or !$user) {
                return $this->responseJson(self::PARAMS_ERROR_CODE, "用户不存在");
            }


            if ($origin == self::ORIGIN_PORTAL) {
                if ($this->security->checkHash($captcha, $user->password)) {
                    $user_id = $user->id;
                    $user->password = $this->security->hash($this->security->getSaltBytes());
//                $user->save();
                } else {
                    return $this->responseJson(self::PARAMS_ERROR_CODE, "手机验证码错误");
                }
            } else {
                $user_id = $user->id;
            }


            if ($user_id) {

                $address_info = $_POST['address'];
                $address_id = $userComponent->getAddressId($user_id, $address_info);
                $linkman_info = $_POST['name'];
                $linkman_id = $userComponent->getLinkmanId($user_id, $mobile, $linkman_info);
                $auto_id = $userComponent->getAutoModelsId($user_id, $modelsExact_id, $carnum);
            } else {
                return $this->responseJson(self::PARAMS_ERROR_CODE, '用户不存在');
            }

        }
    }
}