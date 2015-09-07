<?php

class AppointmentController extends ControllerBase
{

    public function indexAction()
    {
        $a_z=range('A','Z');
        $brands = HdBrands::find( array( 'order' => 'initials asc' ) );
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

        if($_POST){
            $this->session->set('post',$_POST);
        }
        $post=$this->session->get('post');
        if (! $this->session->get( 'auth' )) {
            return $this->response->redirect( "index/login?reUrl=appointment/order" );
        }
        $sumPrice = 0;
        $i = 0;
        foreach ($post['products'] as $row) {
            $data = explode( '-', $row );
            $sumPrice += $data[0];
            $orderDataId[$i]['category_id'] = $data[2];
            $orderDataId[$i]['product_id'] = $data[1];
            $orderDataId[$i]['price'] = $data[0];

            $productName[] = $data[3] . ':' . $data[4];
            $i++;
        }
        $total = $sumPrice + $this->fees;//总价
        $models_id = $post[ 'models_id'];
        $autoName = $post['autoName' ];

        $this->session->set( 'total', $total );
        $this->session->set( 'models_id', $models_id );
        $this->session->set( 'productName', $productName );
        $this->session->set( 'orderDataId', $orderDataId );

        $this->view->setVar( 'total', $total );
        $j=0;
        foreach ($productName as $row){
            $str=explode(':',$row);
            $products[$j]['category']=$str[0];
            $products[$j]['product']=$str[1];
            $j++;
        }

        $this->view->setVar( 'products', $products );
        $this->view->setVar( 'autoName', $autoName );
        $this->view->setVar( 'orderDataId', $orderDataId );
        $this->view->setVar('total',$total);
        $this->view->setVar('fees',$this->fees);
    }

}

