<?php

class OrderController extends ControllerBase
{

    const ORIGIN = 'mobile';

    public function initialize()
    {
        $this->view->setMainView('order');
    }

    public function indexAction()
    {
        //todo bug,数据没过滤
        if ($_POST) {
            $this->session->set('post', $_POST);
        }
        //提交时刷新数据，非提交报错返回提示信息时不刷新
        if ($this->request->isPost()) {
            $this->session->set('products', $this->request->getPost('products', \Phalcon\Filter::FILTER_STRING));
            $this->session->set('models_id', $this->request->getPost('models_id', \Phalcon\Filter::FILTER_STRING));
            $this->session->set('modelsExact_id', $this->request->getPost('modelsExact_id', \Phalcon\Filter::FILTER_STRING));
            $this->session->set('autoName', $this->request->getPost('autoName', \Phalcon\Filter::FILTER_STRING));
            $this->session->set('other', $this->request->getPost('other', \Phalcon\Filter::FILTER_STRING));
        }


        if (!$this->session->get('auth')) {
            return $this->response->redirect("index/login?reUrl=order");
        }
        $sumPrice = 0;
        $i = 0;
        $orderDataId = $productName = array();

        //todo 我操，，太懒了饿；；
        //todo 重新从数据库里面取
        if ('on' == $this->session->get('other')) {
            $this->session->set('remark', '已有配件，仅购买上门服务');
        } else {
            $this->session->set('remark', '');
            foreach ($this->session->get('products') as $row) {
                $data = explode('-', $row);
                $sumPrice += $data[0];
                if (isset($data[2]) && $data[2] != '' && isset($data[1]) && $data[1] != '') {
                    $orderDataId[$i]['category_id'] = $data[2];
                    $orderDataId[$i]['product_id'] = $data[1];
                    $orderDataId[$i]['price'] = $data[0];
                    $productName[] = $data[3] . ':' . $data[4];
                    $i++;
                }
            }
        }

        $total = $sumPrice + $this->fees;//总价
        $models_id = $this->session->get('models_id');
        $autoName = $this->session->get('autoName');

        $this->session->set('total', $total);
        $this->session->set('models_id', $models_id);
        $this->session->set('productName', $productName);
        $this->session->set('orderDataId', $orderDataId);

        $this->view->setVar('total', $total);
        $j = 0;
        $products = array();
        foreach ($productName as $row) {
            $str = explode(':', $row);
            $products[$j]['category'] = $str[0];
            $products[$j]['product'] = $str[1];
            $j++;
        }

        $this->view->setVar('products', $products);
        $this->view->setVar('autoName', $autoName);
        $this->view->setVar('orderDataId', $orderDataId);
        $this->view->setVar('total', $total);
        $this->view->setVar('fees', $this->fees);
        $this->view->setVar('remark', $this->session->get('remark'));


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
        $modelsExact_id = $this->session->get('modelsExact_id');
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
            return $this->response->redirect('order/index');
        }
        if (empty($name)) {
            $this->flash->error("姓名不能为空");
            return $this->response->redirect('order/index');
        }
        if (empty($address)) {
            $this->flash->error("地址不能为空");
            return $this->response->redirect('order/index');
        }
        if (empty($carnum)) {
            $this->flash->error("车牌号不能为空");
            return $this->response->redirect('order/index');
        }
        if (empty($bookTime)) {
            $this->flash->error("预约时间不能为空");
            return $this->response->redirect('order/index');
        }

        $data = array(
            'origin'=>self::ORIGIN,
            'mobile'=>$mobile,'name'=>$name,'address'=>$address,'carnum'=>$carnum,'bookTime'=>$bookTime,'remark'=>$remark,
            'total'=>$total,'models_id'=>$modelsExact_id,'modelsExact_id'=>$modelsExact_id,'productName'=>$productName,'orderDataId'=>$orderDataId
        );

        $fileLogger = new Phalcon\Logger\Adapter\File(APP_PATH.'/cache/interface.log');
        $fileLogger->log('request',json_encode($data));
        $response  = $this->restful->post('http://api.handao365.dev/order/order',$data);
        $fileLogger->log('response',$response);

        $json = json_decode($response,true);
        if($json['statusCode']=='000000'){
            return $this->response->redirect('/order/success/'.$json['data']['order_id']);
        }else{
            return $this->response->redirect('/order/fail');
        }
//        echo ($res);
//
//        exit;



//        if ($_POST['mobile']) {
//            $user_id = $this->session->get('auth')->id;
//            if ($user_id) {
//                $address_info = $_POST['address'];
//                $address_id = $this->getAddressId($user_id, $address_info);
//                $linkman_info = $_POST['name'];
//                $linkman_id = $this->getLinkmanId($user_id, $_POST['mobile'], $linkman_info);
//                $auto_id = $this->getAutoModelsId($user_id, $models_id, $_POST['carnum']);
//            }
//            $HdOrder = new HdOrder();
//            $HdOrder->user_id = $user_id;
//            $HdOrder->auto_id = $auto_id;
//            $HdOrder->products = serialize($productName);
//            $HdOrder->price = $total;//目前没得折扣
//            $HdOrder->total = $total;
//            $HdOrder->linkman_id = $linkman_id;
//            $HdOrder->linkman_info = $linkman_info;
//            $HdOrder->address_id = $address_id;
//            $HdOrder->address_info = $address_info;
//            $HdOrder->remark = $remark;
//            $HdOrder->status = 11;
//            $HdOrder->book_time = $bookTime[0] . '  ' . $bookTime[1];
//            if ($HdOrder->save()) {
//                $order_id = $HdOrder->id;
//
//                foreach ($orderDataId as $order) {
//                    $HdOrderProduct = new HdOrderProduct;
//                    $HdOrderProduct->order_id = $order_id;
//                    $HdOrderProduct->product_id = $order['product_id'];
//                    $HdOrderProduct->product_category = $order['category_id'];
//                    $HdOrderProduct->order_price = $order['price'];
//                    $HdOrderProduct->save();
//                }
//                return $this->response->redirect('index/myorder');
//            }
//        }
//        $this->view->setVar('productName', $productName);
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
            }
        }
        return $auto_id;

    }
}

