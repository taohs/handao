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
        if($this->request->isPost()){
            switch($this->request->getPost('step')){
                case 1:
                    return $this->dispatcher->forward(array('controller'=>'order','action'=>'createStepPassport','params'=>$this->dispatcher->getParams()));// $this->createStepPassport();
                    break;
                case 2:
                    $this->createStepCar();
                    break;
                case 3:
                    $this->createStepProducts();
                    break;
                case 4:
                    $this->createStepFinish();
                    break;
                default:break;
            }
        }
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

    public function createStepPassportAction(){
        var_dump(1);
        var_dump($_POST);

    }
    protected function createStepCar(){

    }
    protected function createStepProducts(){

    }
    protected function createStepFinish(){

    }


}

