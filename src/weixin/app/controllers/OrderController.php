<?php

class OrderController extends ControllerBase
{

    public function indexAction()
    {
        $sumPrice=0;
        $i=0;
        foreach($_POST['products'] as $row){
            $data=explode('-',$row);
            $sumPrice+=$data[0];
            $orderDataId[$i]['product_id']=$data[1];
            $orderDataId[$i]['category_id']=$data[2];
            $productName[]=$data[3].':'.$data[4];
            $i++;
        }
        $total=$sumPrice+$this->fees;//总价
        $models_id = $this->request->getPost( 'models_id' );
        $autoName=$this->request->getPost( 'autoName' );
        /**
         * 下单的时候取这些数据,还差auto_id
         */
        $this->session->set('total',$total);
        $this->session->set('models_id',$models_id);
        $this->session->set('productName',$productName);
        $this->session->set('orderDataId',$orderDataId);

        $this->view->setVar('total',$total);
        $this->view->setVar('productName',$productName);
        $this->view->setVar('autoName',$autoName);

    }


    public function myrderAction()
    {

    }
    public function orderAction(){
        var_dump($_POST);
    }

}

