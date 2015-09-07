<?php

class OrderController extends ControllerBase
{



    public function indexAction(){

    }

    public function orderAction()
    {

        if (!$this->session->get('productName')) {
            //todo 加入提示；
//            return $this->response->redirect( 'maintenance/autoselect' );
        }
        //todo 注入bug，
        //todo 注入bug，未验证汽车型号，
        $total = $this->session->get('total');
        $models_id = $this->session->get('models_id');
        $productName = $this->session->get('productName');
        $orderDataId = $this->session->get('orderDataId');

        /**
         * 新加入过滤
         */
        $mobile = $this->request->getPost('mobile', \Phalcon\Filter::FILTER_FLOAT);
        $name = $this->request->getPost('name', \Phalcon\Filter::FILTER_STRING);
        $address = $this->request->getPost('address', \Phalcon\Filter::FILTER_STRING);
        $carnum = $this->request->getPost('carnum', \Phalcon\Filter::FILTER_STRING);
        $bookTime = $this->request->getPost('bookTime', \Phalcon\Filter::FILTER_STRING);
        $remark = $this->request->getPost('remark', \Phalcon\Filter::FILTER_STRING);

        //todo 没有做 提交空信息处理；；
        //todo 没有过滤手机号码；
        //todo 大爷的，通宵改bug；；

        if (!preg_match('/^1[3-9]{1}[0-9]{9}$/', $mobile)) {
            $this->flash->error("手机格式不正确");
            return $this->response->redirect('appointment/order');
        }
        if (empty($name)) {
            $this->flash->error("姓名不能为空");
            return $this->response->redirect('appointment/order');
        }
        if (empty($address)) {
            $this->flash->error("地址不能为空");
            return $this->response->redirect('appointment/order');
        }
        if (empty($carnum)) {
            $this->flash->error("车牌号不能为空");
            return $this->response->redirect('appointment/order');
        }
        if (empty($bookTime)) {
            $this->flash->error("预约时间不能为空");
            return $this->response->redirect('appointment/order');
        }


        if ($_POST['mobile']) {
            $user_id = $this->session->get('auth')->id;
            if ($user_id) {
                $address_info = $_POST['address'];
                $address_id = $this->getAddressId($user_id, $address_info);
                $linkman_info = $_POST['name'];
                $linkman_id = $this->getLinkmanId($user_id, $_POST['mobile'], $linkman_info);
                $auto_id = $this->getAutoModelsId($user_id, $models_id, $_POST['carnum']);
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

                foreach ($orderDataId as $order) {
                    $HdOrderProduct = new HdOrderProduct;
                    $HdOrderProduct->order_id = $order_id;
                    $HdOrderProduct->product_id = $order['product_id'];
                    $HdOrderProduct->product_category = $order['category_id'];
                    $HdOrderProduct->order_price = $order['price'];
                    $HdOrderProduct->save();
                }
                return $this->response->redirect('index/myorder');
            }
        }
        $this->view->setVar('productName', $productName);
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
    public function getLinkmanId( $user_id, $mobile, $name )
    {
        $linkman = HdUserLinkman::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and mobile=:mobile: and name=:name:  ',
                'bind'       => array( 'user_id' => $user_id, 'mobile' => $mobile, 'name' => $name )
            ) );
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
    public function getAddressId( $user_id, $address_info )
    {
        $address = HdUserAddress::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and address=:address:',
                'bind'       => array( 'user_id' => $user_id, 'address' => $address_info )
            ) );

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
    public function getAutoModelsId( $user_id, $models, $number )
    {
        $autoData = HdUserAuto::findFirst(
            array(
                'conditions' => 'models=:models: and user_id=:user_id: and number=:number:',
                'bind'       => array( 'models' => $models, 'user_id' => $user_id ,'number'=>$number)
            ) );
        if ($autoData) {
            $auto_id = $autoData->id;
        } else {
            $HdUserAuto = new HdUserAuto;
            $HdUserAuto->user_id = $user_id;
            $HdUserAuto->models = $models;
            $HdUserAuto->number=$number;
            if ($HdUserAuto->save()) {
                $auto_id = $HdUserAuto->id;
            }
        }
        return $auto_id;

    }
}

