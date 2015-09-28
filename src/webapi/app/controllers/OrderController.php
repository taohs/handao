<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 15/9/20
 * Time: 18:20
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 15/9/20  Time: 18:20
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class OrderController extends ControllerBase
{

    const SUCCESS_CODE = '000000';
    const PARAMS_ERROR_CODE = '100000';
    const LOGIC_ERROR_CODE = '200000';

    const ORIGIN_MOBILE = 'mobile';
    const ORIGIN_PORTAL = 'portal';
    const ORIGIN_BACKEND = 'backend';
    const ORIGIN_API = 'api';

    /**
     * the apply interface;
     *
     * only accept post information;
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {

        } else {
            //exception
            throw new \Phalcon\Exception("only accept post information");
        }
    }

    function pcAction()
    {

    }


    function wxAction()
    {

    }


    function responseJson($statusCode = '100000', $statusMsg = '用户不存在', $data = array())
    {
        $array = array('statusCode' => $statusCode, 'statusMsg' => $statusMsg, 'data' => $data);
        echo json_encode($array);
        exit;
    }

    public function orderAction()
    {

        if (!$this->session->get('productName')) {
            //todo 加入提示；
//            return $this->response->redirect( 'maintenance/autoselect' );
        }
        //todo 注入bug，
        //todo 注入bug，未验证汽车型号，
        $total = $this->request->getPost('total');
        $models_id = $this->request->getPost('models_id');
        $modelsExact_id = $this->request->getPost('modelsExact_id');
        $productName = $this->request->getPost('productName');
        $orderDataId = $this->request->getPost('orderDataId');


        /**
         * 新加入过滤
         */
        $mobile = $this->request->getPost('mobile', \Phalcon\Filter::FILTER_FLOAT);
        $captcha = $this->request->getPost('captcha', \Phalcon\Filter::FILTER_FLOAT);
        $name = $this->request->getPost('name', \Phalcon\Filter::FILTER_STRING);
        $address = $this->request->getPost('address', \Phalcon\Filter::FILTER_STRING);
        $carnum = $this->request->getPost('carnum', \Phalcon\Filter::FILTER_STRING);
        $bookTime = $this->request->getPost('bookTime', \Phalcon\Filter::FILTER_STRING);
        $remark = $this->request->getPost('remark', \Phalcon\Filter::FILTER_STRING);
        $origin = $this->request->getPost('origin', \Phalcon\Filter::FILTER_STRING);

        $_POST;
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
        if (empty($bookTime)) {
            return $this->responseJson(self::PARAMS_ERROR_CODE, "预约时间不能为空");
        }


        if ($mobile) {
            $user = $this->getUser($mobile);

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
                $address_id = $this->getAddressId($user_id, $address_info);
                $linkman_info = $_POST['name'];
                $linkman_id = $this->getLinkmanId($user_id, $mobile, $linkman_info);
                $auto_id = $this->getAutoModelsId($user_id, $modelsExact_id, $carnum);
            } else {
                return $this->responseJson(self::PARAMS_ERROR_CODE, '用户不存在');
            }

            $HdOrder = new HdOrder();
            $HdOrder->user_id = $user_id;
            $HdOrder->auto_id = $auto_id;
            $HdOrder->products = serialize($productName);
            $HdOrder->price = $total;//目前没得折扣
            $HdOrder->total = $total;
            $HdOrder->linkman_id = $linkman_id;
            $HdOrder->linkman_info = $linkman_info;
            $HdOrder->address_id = $address_id;
            $HdOrder->address_info = $address_info;
            $HdOrder->remark = $remark;
            $HdOrder->status = 11;
            $HdOrder->book_time = $bookTime[0] . '  ' . $bookTime[1];
            if ($HdOrder->save()) {
                $order_id = $HdOrder->id;
                if (!empty($orderDataId)) {

                    foreach ($orderDataId as $order) {

                        if ($productVerifyModel = HdProduct::findFirst($order['product_id'])) {

                            $HdOrderProduct = new HdOrderProduct;
                            $HdOrderProduct->order_id = $order_id;
                            $HdOrderProduct->product_id = $order['product_id'];
                            $HdOrderProduct->product_category = $order['category_id'];
                            $HdOrderProduct->order_price = $order['price'];
                            $HdOrderProduct->save();
                        }
                    }
                }
                return $this->responseJson(self::SUCCESS_CODE, "预约成功", array('order_id' => $order_id));
            }
        }
    }

    public function successAction($oid)
    {
        $order = HdOrder::findFirst($oid);
        if (!$order) {
            return $this->response->redirect('/order/fail');
        }
    }

    public function failAction()
    {

    }

    function getUser($mobile)
    {
        $user = HdUser::findFirst(array('conditions' => 'mobile=:mobile:', 'bind' => array('mobile' => $mobile)));
        if (!$user) {
//            throw new \Phalcon\Exception("用户不存在");
//            return null;
        }
        return $user;
    }

    /**
     * 获取联系ID
     *
     * @param $user_id
     * @param $mobile
     * @param $name
     *
     * @return int
     */
    public function getLinkmanId($user_id, $mobile, $name)
    {
        $linkman = HdUserLinkman::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and mobile=:mobile: and name=:name:  ',
                'bind' => array('user_id' => $user_id, 'mobile' => $mobile, 'name' => $name)
            ));
        if ($linkman) {
            $linkmanId = $linkman->id;
        } else {
            $HdUserLinkman = new HdUserLinkman();
            $HdUserLinkman->mobile = $mobile;
            $HdUserLinkman->name = $name;
            $HdUserLinkman->user_id = $user_id;

            if ($HdUserLinkman->save()) {
                $linkmanId = $HdUserLinkman->id;

            }
        }
        return $linkmanId;
    }

    /**
     * 获取地址的ID
     *
     * @param $user_id
     * @param $address
     *
     * @return int
     */
    public function getAddressId($user_id, $address_info)
    {
        $address = HdUserAddress::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and address=:address:',
                'bind' => array('user_id' => $user_id, 'address' => $address_info)
            ));

        if ($address) {
            $addressId = $address->id;
        } else {
            $HdUserAddress = new HdUserAddress();
            $HdUserAddress->user_id = $user_id;
            $HdUserAddress->address = $address_info;
            if ($HdUserAddress->save()) {
                $addressId = $HdUserAddress->id;

            }
        }
        return $addressId;
    }

    /**
     * 获取车型的ID
     * @param $user_id
     * @param $models
     * @param $number
     *
     * @return int
     */
    public function getAutoModelsId($user_id, $models, $number)
    {
        $autoData = HdUserAuto::findFirst(
            array(
                'conditions' => 'models=:models: and user_id=:user_id: and number=:number:',
                'bind' => array('models' => $models, 'user_id' => $user_id, 'number' => $number)
            ));
        if ($autoData) {
            $auto_id = $autoData->id;
        } else {
            $HdUserAuto = new HdUserAuto;
            $HdUserAuto->user_id = $user_id;
            $HdUserAuto->models = $models;
            $HdUserAuto->number = $number;
            if ($HdUserAuto->save()) {
                $auto_id = $HdUserAuto->id;
            } else {
                throw new RuntimeException("用户汽车保存失败");
            }
        }
        return $auto_id;

    }


}