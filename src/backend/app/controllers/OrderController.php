<?php

class OrderController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction(){

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data'=> HdOrder::find(),
            'page'=> $this->request->getQuery('page',\Phalcon\Filter::FILTER_INT),
            'limit'=>$this->config->paginate->limit
        ));

        $this->view->setVar('paginate',$paginate->getPaginate());
    }

    /**
     * 后台下订单需要四步
     * @1、确定下单人，输入手机号码，确定会员是否存在，不存在则新建会员同事新增改号码未默认联系人，默认选中当前号码为联系人
     * @2、抓去会员名下车辆，显示选择块与选择新车型的下拉框
     * @3、选购商品与服务下单
     * @4、下单成功生成短信发送至会员手机号码
     */
    public function createAction(){
        $model = new HdOrder();
        if($this->request->isPost()){

            var_dump($this->request->getPost());
            $mobile = $this->request->getPost('inputName',\Phalcon\Filter::FILTER_FLOAT);
            $member = $this->getOrderMember($mobile);
            exit;


//            switch($this->request->getPost('step')){
//                case 1:
//                    return $this->dispatcher->forward(array('controller'=>'order','action'=>'createStepPassport','params'=>$this->dispatcher->getParams()));// $this->createStepPassport();
//                    break;
//                case 2:
//                    $this->createStepCar();
//                    break;
//                case 3:
//                    $this->createStepProducts();
//                    break;
//                case 4:
//                    $this->createStepFinish();
//                    break;
//                default:break;
//            }
        }
        $this->view->setVar('model',$model);
    }

    public function updateAction($id){

    }

    public function deleteAction($id){

    }

    protected function _getModel($id){
        $model = HdOrder::findFirst($id);
        if(!$model){
            throw new \Phalcon\Exception('该订单不存在');
        }
        return $model;
    }

    /**
     * @todo 代码盲写，需要验证；
     * @throws \Phalcon\Exception
     *
     * #提交用户手机号码，进入库中查询，查找则带出用户信息车辆和联系人信息，用户不存在新建用户和联系人，在拉出用户信息和车辆
     *
     */
    public function createStepPassportAction(){

        $userMobile = $this->request->getQuery('inputName',\Phalcon\Filter::FILTER_FLOAT);
        $userName = $this->request->getQuery('inputName',\Phalcon\Filter::FILTER_STRING);

        $user = HdUser::findFirst(array(
            'conditions'=>'username=:username:',
            'bind'=>array('username'=>$userMobile)
        ));

        if(!$user){
            /**
             * new a user and linkman
             * @todo new a user and linkman
             */
            $user = new HdUser();
            $user->username = $userMobile;
            $user->password = $this->security->hash($this->config->user->password->default);
            $user->mobile   = $userMobile;
            if(!$user->save()){
                throw new \Phalcon\Exception("新增会员失败");
            }

            $userLinkMan = new HdUserLinkman();
            $userLinkMan->name    = $userName ? $userName : $userMobile ;
            $userLinkMan->mobile  = $userMobile;
            $userLinkMan->user_id = $user->id;
            if(!$userLinkMan->save())
                throw new \Phalcon\Exception("会员新增联系人失败");
        }
        $userLinkMans = HdUserLinkman::find(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array('userId'=>$user->id)
        ));
        /**
         * get the people's cars
         */
        $userCars = HdUserAuto::find(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array('userId'=>$user->id),
        ));

        $this->persistent->set('orderStep',1);
        $this->persistent->set('orderUser',$user);
        $this->persistent->set('orderUserLinkMans',$userLinkMans);
        $this->persistent->set('orderUserCars',$userCars);
    }

    /**
     * @todo 代码盲写，需要验证
     *
     * #后台输入联系人信息；联系人列表信息不可修改；后台下单只能选择联系人或者新增联系人
     * #后台输入车辆信息；车辆列表信息不可修改；后台只能选择车辆或者新增车辆；
     * #确定车辆
     *
     */
    protected function createStepCar(){
        $linkmanId = $this->request->getPost('linkId',\Phalcon\Filter::FILTER_INT);
        $carId = $this->request->getPost('carId',\Phalcon\Filter::FILTER_INT);
        /**
         * @var $user HdUser
         */
        $user = $this->persistent->get('user');

        if(empty($linkmanId)){
            /**
             * 新增联系人
             */
            $linkmanName = $this->request->getPost('linkmanName',\Phalcon\Filter::FILTER_STRING);
            $linkmanMobile = $this->request->getPost('linkmanName',\Phalcon\Filter::FILTER_FLOAT);

            if(empty($linkmanMobile)){
                throw new  \Phalcon\Exception('联系人号码');
            }
            $linkman = new HdUserLinkman();

            $linkman->user_id = $user->id;
            $linkman->mobile  = $linkmanMobile;
            $linkman->name    = $linkmanName ? $linkmanName : $linkmanMobile;
            if(!$linkman->save()){
                throw new \Phalcon\Exception('联系人创建失败');
            }
        }else{
            $linkman = HdUserLinkman::findFirst($linkmanId);
            if(!$linkman or $linkman->user_id != $user->id){
                throw new \Phalcon\Exception('联系人不存在');
            }
        }

        if(empty($carId)){
            /**
             * 新增联系人
             */
            $linkmanName = $this->request->getPost('linkmanName',\Phalcon\Filter::FILTER_STRING);
            $linkmanMobile = $this->request->getPost('linkmanName',\Phalcon\Filter::FILTER_FLOAT);

            if(empty($linkmanMobile)){
                throw new  \Phalcon\Exception('联系人号码');
            }
            $linkman = new HdUserLinkman();
            /**
             * @var $user HdUser
             */
            $user = $this->persistent->get('user');
            $linkman->user_id = $user->id;
            $linkman->mobile  = $linkmanMobile;
            $linkman->name    = $linkmanName ? $linkmanName : $linkmanMobile;
            if(!$linkman->save()){
                throw new \Phalcon\Exception('车辆创建失败');
            }
        }else{
            $car = HdUserAuto::findFirst($carId);
            if(!$car or $car->user_id != $user->id){
                throw new \Phalcon\Exception('该车辆不存在');
            }
        }

    }
    protected function createStepProducts(){

    }
    protected function createStepFinish(){

    }


    protected function getOrderMember($mobile){
        $member = HdUser::findFirst(array('conditions'=>'mobile=:mobile: or username=:mobile:','bind'=>array('mobile'=>$mobile)));
        if(!$member){
            $member = new HdUser();
            $member->username = $mobile;
            $member->mobile   = $mobile;
            $member->password = $this->security->hash($this->config->user->password->default);
            $member->save();
        }
        return $member;
    }

    /**
     * @param $member HdUser
     * @param $modelExact HdAutoModelsExact
     */
    protected function getOrderCar($member,$modelExact){
        $cars = $member->getHdUserAuto();
        $exist = false;
        foreach($cars as $car){
            /**
             * @var $car HdUserAuto
             */
            if($car->models == $modelExact){
                $exist = true;
                break;
            }
        }
        if(!$exist){
            $car = new HdUserAuto();
            $car->models = $modelExact;
            $car->save();
        }else{
            $car = HdUserAuto::findFirst(array(
                'conditions'=>'models=:modelExact: and user_id=:userId:',
                'bind'=>array('modelExact'=>$modelExact,'userId'=>$member->id)
            ));
        }
        return $car;
    }

}

