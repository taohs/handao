<?php

class OrderController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction()
    {

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => HdOrder::find(array('order'=>'id desc')),
            'page' => $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT),
            'limit' => $this->config->paginate->limit,
//            'order'=>'id desc'
        ));


        $this->view->setVar('paginate', $paginate->getPaginate());
        $this->view->setVar('orderComponent', new OrderComponent());
    }

    /**
     * 后台下订单需要四步
     * @1、确定下单人，输入手机号码，确定会员是否存在，不存在则新建会员同事新增改号码未默认联系人，默认选中当前号码为联系人
     * @2、抓去会员名下车辆，显示选择块与选择新车型的下拉框
     * @3、选购商品与服务下单
     * @4、下单成功生成短信发送至会员手机号码
     */
    public function createAction()
    {
        $model = new HdOrder();
        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $brands[0]->id)
        ));

        $autoModelExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $autoModels[0]->id)
        ));


        $productsCategory = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id<>0',
            'bind' => array('active' => 1)
        ));

        $this->saveOrder(null);

        $this->view->setVar('model', $model);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
        $this->view->setVar('autoModelExacts', $autoModelExacts);
        $this->view->setVar('productsCategory', $productsCategory);
    }

    public function updateAction($id)
    {
        $model = $this->_getModel($id);

        $modelAuto = $model->getAuto();
        $modelAutoExact = $modelAuto->getModelExact();
        $modelBrands = $modelAutoExact->getHdBrands();
//        var_dump($modelAutoExact);
//        var_dump($modelBrands);
//        exit;
        $modelModels = $modelAutoExact->getHdAutoModels();


        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $modelBrands->id)
        ));

        $autoModelExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $modelModels->id)
        ));


        $productsCategory = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id<>0',
            'bind' => array('active' => 1)
        ));

        $recommendTemp = HdAutoProductRecommend::find(array(
            'columns'=>'product_id',
            'conditions'=>'exact_id=:exact_id:',
            'bind'=>array('exact_id'=>$modelAutoExact->id)
        ))->toArray();
        $recommendArray= array();
        foreach($recommendTemp as $v){
            $recommendArray[] = $v['product_id'];
        }


        $this->saveOrder($id);



        $modelProducts = $model->getHdOrderProduct();
        $this->view->setVar('model', $model);
        $this->view->setVar('recommendArray', $recommendArray);
        $this->view->setVar('modelLinkman', $model->getLinkman());
        $this->view->setVar('modelAuto', $modelAuto);
        $this->view->setVar('modelAutoExact', $modelAutoExact);
        $this->view->setVar('modelBrands', $modelBrands);
        $this->view->setVar('modelModels', $modelModels);
        $this->view->setVar('modelProducts', $model->getHdOrderProduct());

        $productsIdArray = array();
        foreach ($modelProducts as $v) {
            $productsIdArray[] = $v->product_id;
        }

        $this->view->setVar('modelProductsIdArray', $productsIdArray);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
        $this->view->setVar('autoModelExacts', $autoModelExacts);
        $this->view->setVar('productsCategory', $productsCategory);
    }

    public function deleteAction($id)
    {

    }

    /**
     * 指派订单技师
     * @param $id
     */
    public function assignAction($id)
    {


        $model = $this->_getModel($id);
        $modelAuto = $model->getAuto();
        $modelAutoExact = $modelAuto->getModelExact();
        $modelBrands = $modelAutoExact->getHdBrands();
        $modelModels = $modelAutoExact->getHdAutoModels();


        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $modelBrands->id)
        ));

        $autoModelExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $modelModels->id)
        ));



        $productsCategory = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id<>0',
            'bind' => array('active' => 1)
        ));


        $workerSet = HdTechnician::find(array('conditions'=>'active!=0','order' => 'initials asc,name asc'));

        if ($this->request->isPost()) {
            $tecknician = $this->request->getPost('inputTechnician', \Phalcon\Filter::FILTER_INT);
            $model->technician_id = $tecknician;
            $model->status = OrderComponent::STATUS_ASSIGN_STAFF;
            if ($model->save()) {
                $this->flash->success("指派成功");
            } else {
                $this->flash->error("指派失败");
            }
            return $this->refresh();
        }

        $modelAuto = $model->getAuto();
        $modelProducts = $model->getHdOrderProduct();
        $this->view->setVar('model', $model);
        $this->view->setVar('workerSet', $workerSet);
        $this->view->setVar('modelLinkman', $model->getLinkman());
        $this->view->setVar('modelAuto', $modelAuto);
        $this->view->setVar('modelAutoExact', $modelAutoExact);
        $this->view->setVar('modelBrands', $modelBrands);
        $this->view->setVar('modelModels', $modelModels);
        $this->view->setVar('modelProducts', $model->getHdOrderProduct());

        $productsIdArray = array();
        foreach ($modelProducts as $v) {
            $productsIdArray[] = $v->product_id;
        }

        $this->view->setVar('modelProductsIdArray', $productsIdArray);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
        $this->view->setVar('autoModelExacts', $autoModelExacts);
        $this->view->setVar('productsCategory', $productsCategory);
    }

    /**
     * 指派订单技师
     * @param $id
     */
    public function PayAction($id)
    {


        $model = $this->_getModel($id);
        $modelAuto = $model->getAuto();
        $modelAutoExact = $modelAuto->getModelExact();
        $modelBrands = $modelAutoExact->getHdBrands();
        $modelModels = $modelAutoExact->getHdAutoModels();


        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $modelBrands->id)
        ));

        $autoModelExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $modelModels->id)
        ));



        $productsCategory = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id<>0',
            'bind' => array('active' => 1)
        ));


        $workerSet = HdTechnician::find(array('order' => 'initials asc,name asc'));

        if ($this->request->isPost()) {
            $payed_amount = $this->request->getPost('inputPayedAmount', \Phalcon\Filter::FILTER_FLOAT);
            $model->payed_amount = $payed_amount;
            $model->payed_time = date('Y-m-d H:i:s');
            $model->status = OrderComponent::STATUS_ASSIGN_PAYED;
            if ($model->save()) {
                $this->flash->success("支付成功");
            } else {
                $this->flash->error("支付失败");
            }
            return $this->refresh();
        }

        $modelAuto = $model->getAuto();
        $modelProducts = $model->getHdOrderProduct();
        $this->view->setVar('model', $model);
        $this->view->setVar('workerSet', $workerSet);
        $this->view->setVar('modelLinkman', $model->getLinkman());
        $this->view->setVar('modelAuto', $modelAuto);
        $this->view->setVar('modelAutoExact', $modelAutoExact);
        $this->view->setVar('modelBrands', $modelBrands);
        $this->view->setVar('modelModels', $modelModels);
        $this->view->setVar('modelProducts', $model->getHdOrderProduct());

        $productsIdArray = array();
        foreach ($modelProducts as $v) {
            $productsIdArray[] = $v->product_id;
        }

        $this->view->setVar('modelProductsIdArray', $productsIdArray);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
        $this->view->setVar('autoModelExacts', $autoModelExacts);
        $this->view->setVar('productsCategory', $productsCategory);
    }

    /**
     * 指派订单技师
     * @param $id
     */
    public function statusAction($id)
    {


        $model = $this->_getModel($id);
        $modelAuto = $model->getAuto();
        $modelAutoExact = $modelAuto->getModelExact();
        $modelBrands = $modelAutoExact->getHdBrands();
        $modelModels = $modelAutoExact->getHdAutoModels();


        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $modelBrands->id)
        ));

        $autoModelExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $modelModels->id)
        ));



        $productsCategory = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id<>0',
            'bind' => array('active' => 1)
        ));


        $workerSet = HdTechnician::find(array('order' => 'initials asc,name asc'));

        if ($this->request->isPost()) {
            $status = $this->request->getPost('inputStatus', \Phalcon\Filter::FILTER_INT);
            $model->status = $status;
            if ($model->save()) {
                $this->flash->success("保存成功");
            } else {
                $this->flash->error("保存失败");
            }
            return $this->refresh();
        }

        $modelAuto = $model->getAuto();
        $modelProducts = $model->getHdOrderProduct();
        $this->view->setVar('model', $model);
        $this->view->setVar('workerSet', $workerSet);
        $this->view->setVar('modelLinkman', $model->getLinkman());
        $this->view->setVar('modelAuto', $modelAuto);
        $this->view->setVar('modelAutoExact', $modelAutoExact);
        $this->view->setVar('modelBrands', $modelBrands);
        $this->view->setVar('modelModels', $modelModels);
        $this->view->setVar('modelProducts', $model->getHdOrderProduct());

        $productsIdArray = array();
        foreach ($modelProducts as $v) {
            $productsIdArray[] = $v->product_id;
        }

        $this->view->setVar('modelProductsIdArray', $productsIdArray);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
        $this->view->setVar('autoModelExacts', $autoModelExacts);
        $this->view->setVar('productsCategory', $productsCategory);
        $this->view->setVar('orderComponent', new OrderComponent());
    }


    protected function _getModel($id)
    {
        $model = HdOrder::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Exception('该订单不存在');
        }
        return $model;
    }

    protected function saveOrder($id = null)
    {
        if ($this->request->isPost()) {


            $name = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $mobile = $this->request->getPost('inputMobile', \Phalcon\Filter::FILTER_FLOAT);
            $address = $this->request->getPost('inputAddress', \Phalcon\Filter::FILTER_STRING);
            $productList = $this->request->getPost('inputProducts', \Phalcon\Filter::FILTER_INT);
            $inputBookTime = $this->request->getPost('inputBookTime', \Phalcon\Filter::FILTER_STRING);
            $inputRemark = $this->request->getPost('inputRemark', \Phalcon\Filter::FILTER_INT);
            $modelExact = $this->request->getPost('inputAutoModelExact', \Phalcon\Filter::FILTER_INT);
            $autoNumber = $this->request->getPost('inputAutoNumber', \Phalcon\Filter::FILTER_STRING);
            $remark = $this->request->getPost('inputRemark', \Phalcon\Filter::FILTER_STRING);


            /**
             * 初始化商品
             */
            $products = HdProduct::find(array('conditions' => 'id in ({id:array})', 'bind' => array('id' => $productList), 'order' => 'category'));
            $orderProduct = array();
            $productName = $orderDataId =array();
            $orderPrice = 150;
            foreach ($products as $p) {
                //初始化名称：
                $orderProduct[$p->category] = $p->name;
                $productName[] =  $p->getHdProductCategory()->name .':'. $p->name;
                $orderDataIdTemp = array();
                $orderDataIdTemp['category_id'] =  $p->category;
                $orderDataIdTemp['product_id'] =  $p->id;
                $orderDataIdTemp['price'] =  $p->member_price;
                $orderDataId[] =$orderDataIdTemp;
                //总价格：
                $orderPrice += $p->member_price;

            }


            $auth = $this->session->get('auth');
            $data = array(
                'origin'=>self::ORIGIN,

                'mobile'=>$mobile,'name'=>$name,'address'=>$address,'carnum'=>$autoNumber,'bookTime'=>$inputBookTime,'remark'=>$remark,
                'total'=>$orderPrice,'models_id'=>$modelExact,'modelsExact_id'=>$modelExact,'productName'=>$productName,'orderDataId'=>$orderDataId
            );

            $fileLogger = new Phalcon\Logger\Adapter\File(APP_PATH.'/cache/interface.log');
            $fileLogger->log('request',json_encode($data));
            $response  = $this->restful->post('http://api.handao365.dev/order/order',$data);
            $fileLogger->log('response',$response);

            $json = json_decode($response,true);
            if($json['statusCode']=='000000'){
                $this->flash->success($json['statusMsg']);
            }else{
                $this->flash->error($json['statusMsg']);

            }
            return $this->refresh();



            /**
             * 初始化用户和联系人
             */
            $objectMember = $this->getOrderMember($mobile, $name);
            $linkmanObject = HdUserLinkman::findFirst(array(
                'conditions' => 'mobile=:mobile: and name=:name:',
                'bind' => array('mobile' => $mobile, 'name' => $name)
            ));


            /**
             * 初始化汽车
             */
            $objectCar = $this->getOrderCar($objectMember, $modelExact, $autoNumber);

            /**
             * 初始化地址
             */
            $addressObject = $this->getOrderAddress($objectMember, $address);





            $this->db->begin();
            /**
             * 初始化订单
             */
            try {

                $orderObject = is_null($id) ? new HdOrder() : HdOrder::findFirst($id);
                $orderObject->user_id = $objectMember->id;
                $orderObject->auto_id = $objectCar->id;
                $orderObject->products = serialize($orderProduct);

                $orderObject->price = $orderPrice;
                $orderObject->total = $orderPrice;

                $orderObject->linkman_id = $linkmanObject->id;
                $orderObject->linkman_info = $linkmanObject->name;
                $orderObject->address_id = $addressObject->id;
                $orderObject->address_info = $addressObject->address;
                $orderObject->book_time = $inputBookTime;
                $orderObject->remark = $remark;
                $orderObject->save();

                $this->saveOrderProducts($orderObject,$products);

//                $orderProductSet = $orderObject->getHdOrderProduct();
//                if ($orderProductSet) {
//                    foreach ($orderProductSet as $p) {
//                        $p->delete();
//                    }
//                }
//
//
//                /**
//                 * 初始化订单产品
//                 */
//                foreach ($products as $p) {
//                    //初始化名称：
//                    $orderProductObject = new HdOrderProduct();
//                    $orderProductObject->order_id = $orderObject->id;
//                    $orderProductObject->product_category = $p->category;
//                    $orderProductObject->product_id = $p->id;
//                    $orderProductObject->order_price = $p->member_price;
//                    $orderProductObject->market_price = $p->market_price;
//                    $orderProductObject->member_price = $p->member_price;
//                    $orderProductObject->attributes = $p->attributes;
//                    $orderProductObject->description = $p->description;
//                    $orderProductObject->active = $p->active;
//                    $orderProductObject->activity_price = $p->activity_price;
//                    $orderProductObject->logs = serialize($orderProductObject);
//                    $orderProductObject->save();
//                    unset($orderProductObject);
//                }
                $this->db->commit();
                $this->flash->success("保存成功");
            } catch (Exception $e) {
                $this->db->rollback();
                $this->flash->error("保存失败" ."  ". $e->getMessage());

            }

            return $this->refresh();

        }
    }

    protected function saveOrderProducts($orderObject, $products)
    {
        $orderProductSet = $orderObject->getHdOrderProduct();
        $orderProductIdSet = array();
        if ($orderProductSet) {
            foreach ($orderProductSet as $p) {
                $orderProductIdSet[] = $p->product_id;
            }
        }

        $productsSet = array();
        foreach ($products as $p){
            $productsSet[]=$p->id;
        }


        $hander = array_intersect($productsSet,$orderProductIdSet);


        if ($orderProductSet) {
            foreach ($orderProductSet as $p) {
               if(!in_array($p->product_id,$hander)){
                   if($p->active == 1){
                       throw new \Phalcon\Exception("已经被使用的商品不能被替换");
                   }else{
                       $p->delete();
                   }
               }
            }
        }

        /**
         * 初始化订单产品
         */
        foreach ($products as $p) {
            //初始化名称：
            if (!in_array($p->id, $hander)) {
                $orderProductObject = new HdOrderProduct();
                $orderProductObject->order_id = $orderObject->id;
                $orderProductObject->product_category = $p->category;
                $orderProductObject->product_id = $p->id;
                $orderProductObject->order_price = $p->member_price;
                $orderProductObject->market_price = $p->market_price;
                $orderProductObject->member_price = $p->member_price;
                $orderProductObject->attributes = $p->attributes;
                $orderProductObject->description = $p->description;
                $orderProductObject->active = $p->active;
                $orderProductObject->activity_price = $p->activity_price;
                $orderProductObject->logs = serialize($orderProductObject);
                $orderProductObject->save();
                unset($orderProductObject);
            }
        }
    }

    /**
     * @todo 代码盲写，需要验证；
     * @throws \Phalcon\Exception
     *
     * #提交用户手机号码，进入库中查询，查找则带出用户信息车辆和联系人信息，用户不存在新建用户和联系人，在拉出用户信息和车辆
     *
     */
    public function createStepPassportAction()
    {

        $userMobile = $this->request->getQuery('inputName', \Phalcon\Filter::FILTER_FLOAT);
        $userName = $this->request->getQuery('inputName', \Phalcon\Filter::FILTER_STRING);

        $user = HdUser::findFirst(array(
            'conditions' => 'username=:username:',
            'bind' => array('username' => $userMobile)
        ));

        if (!$user) {
            /**
             * new a user and linkman
             * @todo new a user and linkman
             */
            $user = new HdUser();
            $user->username = $userMobile;
            $user->password = $this->security->hash($this->config->user->password->default);
            $user->mobile = $userMobile;
            if (!$user->save()) {
                throw new \Phalcon\Exception("新增会员失败");
            }

            $userLinkMan = new HdUserLinkman();
            $userLinkMan->name = $userName ? $userName : $userMobile;
            $userLinkMan->mobile = $userMobile;
            $userLinkMan->user_id = $user->id;
            if (!$userLinkMan->save())
                throw new \Phalcon\Exception("会员新增联系人失败");
        }
        $userLinkMans = HdUserLinkman::find(array(
            'conditions' => 'user_id=:userId:',
            'bind' => array('userId' => $user->id)
        ));
        /**
         * get the people's cars
         */
        $userCars = HdUserAuto::find(array(
            'conditions' => 'user_id=:userId:',
            'bind' => array('userId' => $user->id),
        ));

        $this->persistent->set('orderStep', 1);
        $this->persistent->set('orderUser', $user);
        $this->persistent->set('orderUserLinkMans', $userLinkMans);
        $this->persistent->set('orderUserCars', $userCars);
    }

    /**
     * @todo 代码盲写，需要验证
     *
     * #后台输入联系人信息；联系人列表信息不可修改；后台下单只能选择联系人或者新增联系人
     * #后台输入车辆信息；车辆列表信息不可修改；后台只能选择车辆或者新增车辆；
     * #确定车辆
     *
     */
    protected function createStepCar()
    {
        $linkmanId = $this->request->getPost('linkId', \Phalcon\Filter::FILTER_INT);
        $carId = $this->request->getPost('carId', \Phalcon\Filter::FILTER_INT);
        /**
         * @var $user HdUser
         */
        $user = $this->persistent->get('user');

        if (empty($linkmanId)) {
            /**
             * 新增联系人
             */
            $linkmanName = $this->request->getPost('linkmanName', \Phalcon\Filter::FILTER_STRING);
            $linkmanMobile = $this->request->getPost('linkmanName', \Phalcon\Filter::FILTER_FLOAT);

            if (empty($linkmanMobile)) {
                throw new  \Phalcon\Exception('联系人号码');
            }
            $linkman = new HdUserLinkman();

            $linkman->user_id = $user->id;
            $linkman->mobile = $linkmanMobile;
            $linkman->name = $linkmanName ? $linkmanName : $linkmanMobile;
            if (!$linkman->save()) {
                throw new \Phalcon\Exception('联系人创建失败');
            }
        } else {
            $linkman = HdUserLinkman::findFirst($linkmanId);
            if (!$linkman or $linkman->user_id != $user->id) {
                throw new \Phalcon\Exception('联系人不存在');
            }
        }

        if (empty($carId)) {
            /**
             * 新增联系人
             */
            $linkmanName = $this->request->getPost('linkmanName', \Phalcon\Filter::FILTER_STRING);
            $linkmanMobile = $this->request->getPost('linkmanName', \Phalcon\Filter::FILTER_FLOAT);

            if (empty($linkmanMobile)) {
                throw new  \Phalcon\Exception('联系人号码');
            }
            $linkman = new HdUserLinkman();
            /**
             * @var $user HdUser
             */
            $user = $this->persistent->get('user');
            $linkman->user_id = $user->id;
            $linkman->mobile = $linkmanMobile;
            $linkman->name = $linkmanName ? $linkmanName : $linkmanMobile;
            if (!$linkman->save()) {
                throw new \Phalcon\Exception('车辆创建失败');
            }
        } else {
            $car = HdUserAuto::findFirst($carId);
            if (!$car or $car->user_id != $user->id) {
                throw new \Phalcon\Exception('该车辆不存在');
            }
        }

    }

    protected function createStepProducts()
    {

    }

    protected function createStepFinish()
    {

    }


    protected function getOrderMember($mobile, $name)
    {
        $member = HdUser::findFirst(array('conditions' => 'mobile=:mobile: or username=:mobile:', 'bind' => array('mobile' => $mobile)));
        if (!$member) {
            $member = new HdUser();
            $member->username = $mobile;
            $member->mobile = $mobile;
            $member->password = $this->security->hash($this->config->user->password->default);
            $member->save();
        }
        $memberLinkmans = $member->getHdUserLinkman();

        if ($memberLinkmans) {
            $linkman = false;
            foreach ($memberLinkmans as $man) {
                if ($man->mobile == $mobile && $man->name == $name) {
                    $linkman = $man;
                    break;
                }
            }
            if (!$linkman) {
                $man = new HdUserLinkman();
                $man->user_id = $member->id;
                $man->name = $name;
                $man->mobile = $mobile;
                $man->save();
            }
        }

        return $member;
    }

    protected function getOrderAddress($member, $address)
    {

        $addressList = $member->getHdUserAddress();

        if ($addressList) {
            $rel = false;
            foreach ($addressList as $row) {
                if ($row->address == $address) {
                    $rel = $row;
                    break;
                }
            }

            if (!$rel) {
                $userAddress = new HdUserAddress();
                $userAddress->user_id = $member->id;
                $userAddress->address = $address;
                $userAddress->save();
            } else {
                $userAddress = $rel;
            }
        }

        return $userAddress;
    }

    /**
     * @param $member HdUser
     * @param $modelExact HdAutoModelsExact
     * @param $autoNumber string
     * @return HdUserAuto
     */
    protected function getOrderCar($member, $modelExact, $autoNumber)
    {

        $cars = $member->getHdUserAuto();

        $exist = false;

        foreach ($cars as $car) {
            /**
             * @var $car HdUserAuto
             */
            if ($car->models == $modelExact and $autoNumber == $car->number) {
                $exist = $car;
                break;
            }
        }
        if (!$exist) {
            $car = new HdUserAuto();
            $car->user_id = $member->id;
            $car->number = $autoNumber;
            $car->models = $modelExact;
            $car->save();
        } else {
//            $car = HdUserAuto::findFirst(array(
//                'conditions'=>'models=:modelExact: and user_id=:userId:',
//                'bind'=>array('modelExact'=>$modelExact,'userId'=>$member->id)
//            ));
            $car = $exist;
        }
        return $car;
    }

    protected function createOrder($member, $linkman, $address, $auto, $products)
    {

    }
}

