<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
//        return $this->dispatcher->forward(array('controller'=>'dashboard','action'=>'index'));
        $member = HdUser::count();
        $orderCriteria = array(
            'column'=>'total',
            'conditions'=>'status=:status:',
            'bind'=>array('status'=>OrderComponent::STATUS_RESULT_SUCCESS)
        );
        $orderCount = HdOrder::count($orderCriteria);
        $orderSum = HdOrder::sum($orderCriteria);
        $memberCars = HdUserAuto::count();

        $this->view->setVar('member',$orderCount?$orderCount:0);
        $this->view->setVar('orderCount',$member?$member:0);
        $this->view->setVar('orderSum',$orderSum?$orderSum:0);
        $this->view->setVar('memberCars',$memberCars?$memberCars:0);
    }

}

