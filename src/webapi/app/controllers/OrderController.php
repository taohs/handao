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
        $user_id = $this->request->getPost('user_id', \Phalcon\Filter::FILTER_FLOAT);
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
        if ($origin == self::ORIGIN_MOBILE) {
            if (empty($user_id)) {
                return $this->responseJson(self::PARAMS_ERROR_CODE, "用户ID不能为空");
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

        $userComponent = new UserComponent();

        if ($mobile) {

            /**
             * 门户网站需要验证短信验证码。
             * 微信和后台不需要验证短信验证码。
             */
            if ($origin == self::ORIGIN_PORTAL or $origin == self::ORIGIN_BACKEND) {
                $user = $userComponent->getUserByMobile($mobile);

                if (empty($user) or !$user) {
                    return $this->responseJson(self::PARAMS_ERROR_CODE, "用户不存在");
                }

                if ($this->security->checkHash($captcha, $user->password) or $origin == self::ORIGIN_BACKEND ) {
                    $user_id = $user->id;
                    $user->password = $this->security->hash($this->security->getSaltBytes());
//                $user->save();
                } else {
                    return $this->responseJson(self::PARAMS_ERROR_CODE, "手机验证码错误");
                }
            } else {
                $user = $userComponent->getUserById($user_id);

                if (empty($user) or !$user) {
                    return $this->responseJson(self::PARAMS_ERROR_CODE, "用户不存在");
                }

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

    public function editAction($oid){

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




}