<?php

class OrderController extends ControllerBase
{




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
            $user_id = $this->session->get( 'auth' )->id;
            if ($user_id) {
                $address_info = $_POST['address'];

                $address_id = $this->getAddressId( $user_id, $address_info );


                $linkman_info = $_POST['name'];

                $linkman_id = $this->getLinkmanId( $user_id, $_POST['mobile'], $linkman_info );

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
            $HdOrder->status=11;
            $HdOrder->book_time = $_POST['bookTime'][0] . '  ' . $_POST['bookTime'][1];
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

                return $this->response->redirect( 'index' );
            }


        }
        $this->view->setVar('productName',$productName);
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
