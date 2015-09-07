<?php

class AppointmentController extends ControllerBase
{

    public function indexAction()
    {
        $a_z=range('A','Z');
        $brands = HdBrands::find( array( 'order' => 'initials asc' ) );
        $brandsInitials= array();
        foreach($brands as $b){
            $brandsInitials[] = $b->initials;
        }

        $a_z = array_intersect($a_z,$brandsInitials);
        $this->view->setvar( 'brands', $brands );
        $this->view->setVar('a_z',$a_z);
    }

    public function notautoAction()
    {

    }

    public function serviceAction()
    {
        $brands_id = $this->request->getQuery( 'brands_id' );
        $models_id = $this->request->getQuery( 'models_id' );


        $models = HdAutoModels::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $models_id )
        ) );
        if (! $models) {
            return $this->response->redirect( 'maintenance/autoselect' );
        }
        $brands = HdBrands::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $brands_id )
        ) );
        $category = HdProductCategory::find( array(
            "conditions" => "parent_id =0"

        ) );
        $cates = HdProductCategory::find( array(
            "conditions" => "parent_id <>0"

        ) );
        $product = HdProduct::find()->toArray();

        $this->view->setVar( 'brands', $brands );
        $this->view->setVar( 'models', $models );
        $this->view->setVar( 'category', $category );
        $this->view->setVar( 'product', $product );
        $this->view->setVar( 'fees', $this->fees );
        $this->view->setVar( 'cates', $cates );

    }

    public function orderAction()
    {

        //todo bug,数据没过滤
        if ($_POST) {
            $this->session->set('post', $_POST);
        }
        //提交时刷新数据，非提交报错返回提示信息时不刷新
        if ($this->request->isPost()) {
            $this->session->set('products', $this->request->getPost('products', \Phalcon\Filter::FILTER_STRING));
            $this->session->set('models_id', $this->request->getPost('models_id', \Phalcon\Filter::FILTER_STRING));
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
                $orderDataId[$i]['category_id'] = $data[2];
                $orderDataId[$i]['product_id'] = $data[1];
                $orderDataId[$i]['price'] = $data[0];

                $productName[] = $data[3] . ':' . $data[4];
                $i++;
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

}

