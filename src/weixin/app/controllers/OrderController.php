<?php

class OrderController extends ControllerBase
{
    public function initialize()
    {


        $this->view->setMainView( 'order' );
    }

    public function indexAction()
    {
        $sumPrice = 0;
        $i = 0;

        foreach ($_POST['products'] as $row) {
            $data = explode( '-', $row );
            $sumPrice += $data[0];
            $orderDataId[$i]['category_id'] = $data[2];
            $orderDataId[$i]['product_id'] = $data[1];
            $orderDataId[$i]['price'] = $data[0];



            $productName[] = $data[3] . ':' . $data[4];
            $i++;

        }
        $total = $sumPrice + $this->fees;//总价
        $models_id = $this->request->getPost( 'models_id' );
        $autoName = $this->request->getPost( 'autoName' );
        /**
         * 下单的时候取这些数据,还差auto_id
         */
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


    public function orderAction()
    {

        if (! $this->session->get( 'productName' )) {
            return $this->response->redirect( 'maintenance/autoselect' );
        }
        $total = $this->session->get( 'total' );
        $models_id = $this->session->get( 'models_id' );
        $productName = $this->session->get( 'productName' );
        $orderDataId = $this->session->get( 'orderDataId' );

        if ($_POST['mobile']) {
            $user_id = $this->getUserId( $_POST['mobile'] );
            if ($user_id) {
                $linkman_id = $this->getLinkmanId( $user_id, $_POST['mobile'], $_POST['name'] );
                $linkman_info = $_POST['name'];
                $address_id = $this->getAddressId( $user_id, $_POST['address'] );
                $address_info = $_POST['address'];
                $auto_id = $this->getAutoModelsId( $user_id, $models_id, $_POST['carnum'] );
            }
            $HdOrder = new HdOrder();
            $HdOrder->user_id = $user_id;
            $HdOrder->auto_id = $auto_id;
            $HdOrder->products = serialize( $productName );
            $HdOrder->price = $total;//目前没得折扣
            $HdOrder->total = $total;
            $HdOrder->linkman_id = $linkman_id;
            $HdOrder->linkman_info = $linkman_info;
            $HdOrder->address_id = $address_id;
            $HdOrder->address_info = $address_info;
            $HdOrder->remark = $_POST['remark'];

            $HdOrder->service_time = $_POST['serviceTime'][0] . '  ' . $_POST['serviceTime'][1];
            $HdOrder->book_time = date( 'Y-m-d H:i:s' );
            if ($HdOrder->save()) {
                $order_id=$HdOrder->id;

                foreach($orderDataId as  $order){
                    $HdOrderProduct=new HdOrderProduct;
                    $HdOrderProduct->order_id=$order_id;
                    $HdOrderProduct->product_id=$order['product_id'];
                    $HdOrderProduct->product_category=$order['category_id'];
                    $HdOrderProduct->order_price=$order['price'];
                    $HdOrderProduct->save();
                }
                return $this->response->redirect( 'index/myorder' );
            }


        }
        $this->view->setVar('productName',$productName);
    }



    /**
     * 获取用户ID ，如果是新手机号码，就生成一个新用户
     *
     * @param $mobile
     *
     * @return int
     */
    public function getUserId( $mobile )
    {
        $user = HdUser::findFirst( array( 'conditions' => 'mobile=:mobile:', 'bind' => array( 'mobile' => $mobile ) ) );
        if ($user) {
            $user_id = $user->id;
        } else {
            $HdUser = new HdUser();
            $HdUser->mobile = $_POST['mobile'];
            $HdUser->username = $_POST['mobile'];
            $HdUser->password = $this->security->hash( $_POST['mobile'] );
            $HdUser->update_time = date( "Y-m-d H:i:s" );
            $HdUser->create_time = date( "Y-m-d H:i:s" );
            if ($HdUser->save()) {
                $user_id = $HdUser->id;

            } else {
                foreach ($HdUser->getMessages() as $message) {
                    var_dump( $message );
                    exit;
                    //$this->flash->error( (string)$message );
                }
            }
        }
        return $user_id;
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
    public function getAddressId( $user_id, $address )
    {
        $address = HdUserAddress::findFirst(
            array(
                'conditions' => 'user_id=:user_id: and address=:address:',
                'bind'       => array( 'user_id' => $user_id, 'address' => $address )
            ) );
        if ($address) {
            $addressId = $address->id;
        } else {
            $HdUserAddress = new HdUserAddress();
            $HdUserAddress->user_id = $user_id;
            $HdUserAddress->address = $address;
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

