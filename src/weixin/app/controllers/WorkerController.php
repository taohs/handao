<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/31/15
 * Time: 23:08
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/31/15  Time: 23:08
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

/**
 *
 * 技师工作人员前台操作
 *
 * Class WorkerController
 */
class WorkerController extends ControllerBase
{

    public $sessionName = 'worker';

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function onConstruct()
    {
        // TODO: Implement __construct() method.

        $this->view->setMainView('');
    }

    function getAuth()
    {
        $auth = $this->session->get($this->sessionName);
        if ($auth) {
            return $auth;
        } else {
            $this->response->redirect('worker/login');
        }
    }


    function indexAction()
    {
        $dispatcher = $this->dispatcher;
        return $dispatcher->forward(array(
            'controller' => 'worker',
            'action' => 'dashboard',
            'params' => $dispatcher->getParams()
        ));
    }


    /**
     * login page
     */
    function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {

                $username = $this->request->getPost('username', \Phalcon\Filter::FILTER_STRING);
                $id = $this->request->getPost('number', \Phalcon\Filter::FILTER_STRING);
                $password = $this->request->getPost('password', \Phalcon\Filter::FILTER_STRING);

                $worker = HdTechnician::findFirst($id);
                if ($username == $worker->username && $this->security->checkHash($password, $worker->password)) {
                    $this->session->set($this->sessionName, $worker);
                    $this->session->remove('auth');
                    $this->response->redirect('worker/dashboard');
                } else {
                    $this->flash->error("登录失败");
                }
            } else {
                $this->flash->error("令牌验证失效");
            }
        }
    }

    function logoutAction()
    {
        $this->session->remove($this->sessionName);
    }

    /**
     * 工作台 订单列表
     */
    function dashboardAction($status = 'todo')
    {

        $finished = 'finished';

        $auth = $this->getAuth();

        if (!$auth) {
            return $this->response->redirect('worker/login');
        }

        if ($status != $finished) {
            $orders = HdOrder::find(array(
                'conditions' => 'technician_id=:technician: and status in ({status:array})',
                'bind' => array(
                    'technician' => $auth->id,
                    'status' => array(
                        OrderComponent::STATUS_ASSIGN_PAYED,
                        OrderComponent::STATUS_ASSIGN_SERVICE,
                        OrderComponent::STATUS_ASSIGN_STAFF
                    )
                )
            ));
        } else {
            $orders = HdOrder::find(array(
                'conditions' => 'technician_id=:technician: and status in ({status:array})',
                'bind' => array(
                    'technician' => $auth->id,
                    'status' => array(
                        OrderComponent::STATUS_ASSIGN_FEEDBACK,
                        OrderComponent::STATUS_RESULT_SUCCESS,
                    )
                )
            ));
        }

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $orders,
            'limit' => 1,
            'page' => $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT)
        ));


        $this->view->setMainView('index');
        $this->view->setVar('orders', $orders);
        $this->view->setVar('page', $paginate->getPaginate());
        $this->view->setVar('userData', $auth);
        $this->view->setVar('status', $status);
        $this->view->setVar('finished', $finished);
        $this->view->setVar('orderSuccessStatus', OrderComponent::STATUS_RESULT_SUCCESS);

    }


    /**
     * @param $oid 订单id
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @throws \Phalcon\Exception
     */
    function createReportAction($oid = null)
    {
        $order = HdOrder::findFirst($oid);
        if (!$order) {
            throw new \Phalcon\Exception('该订单不存在');
        }
        $auth = $this->getAuth();

        if (!$auth) {
            return $this->response->redirect('worker/login');
        }
        if ($order->technician_id != $auth->id) {
            throw new \Phalcon\Exception('该订单未指派给您');
        }

        $model = new HdUserAutoReport();

        $modelExist = HdUserAutoReport::findFirst(array(
            'conditions' => 'order_id=:orderId:',
            'bind' => array('orderId' => $order->id)
        ));

        if ($modelExist) {
            $this->flash->error("该订单已经提交报告");
        }

        if ($this->request->getPost()) {


            if ($modelExist) {
                return $this->refresh();
            }
            /**
             * report_lights
             */
            try {


                $this->db->begin();
                $model->auto_id = $order->auto_id;
                $model->order_id = $order->id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->save();

                $order->status = OrderComponent::STATUS_ASSIGN_FEEDBACK;
                $order->service_time = date('Y-m-d H:i:s');
                $order->save();

                /**
                 * 使用商品
                 */
                $this->useProducts();

                $report_lights = $this->saveLights($model);
                $report_oilFilterBattery = $this->saveOilFilterBattery($model);
                $report_tire = $this->saveTire($model);
                $report_other = $this->saveOther($model);


                $summaryObject = new HdUserAutoReportSummary();
                $summaryObject->order_id = $model->order_id;
                $summaryObject->report_id = $model->id;
                $summaryObject->appearance_lighting = $report_lights;
                $summaryObject->oil_filter_battery = $report_oilFilterBattery;
                $summaryObject->tire_brake = $report_tire;
                $summaryObject->other = $report_other;
                $summaryObject->total = floor(0.25 * $report_lights + 0.3 * $report_oilFilterBattery + 0.3 * $report_tire + 0.15 * $report_other);
                $summaryObject->save();
                $this->db->commit();
                $this->flash->success('保存成功');
            } catch (Exception $e) {
                $this->flash->error('保存失败');
                $this->db->rollback();

            }


//            return $this->refresh();
        }


        $this->view->setVar('order', $order);
        $this->view->setVar('orderLinkman', $order->getLinkman());
        $this->view->setVar('orderAuto', $order->getAuto());
        $this->view->setVar('orderAddress', $order->getAddress());
        $this->view->setVar('model', $model);

    }


    /**
     * 查看订单报告
     */
    function updateReportAction($oid)
    {
        $order = HdOrder::findFirst($oid);
        if (!$order) {
            throw new \Phalcon\Exception('该订单不存在');
        }
        $auth = $this->getAuth();

        if (!$auth) {
            return $this->response->redirect('worker/login');
        }
        if ($order->technician_id != $auth->id) {
            throw new \Phalcon\Exception('该订单未指派给您');
        }


        $modelExist = HdUserAutoReport::findFirst(array(
            'conditions' => 'order_id=:orderId:',
            'bind' => array('orderId' => $order->id)
        ));
        $model = $modelExist;

        if (!$modelExist) {
            $this->flash->error("该订单尚未已经提交报告");
        }

        $lightModel = HdUserAutoReportLight::findFirst(array(
            'conditions' => 'report_id=:reportId:',
            'bind' => array('reportId' => $model->id)
        ));

        $oilFilterBatteryModel = HdUserAutoReportOilFilter::findFirst(array(
            'conditions' => 'report_id=:reportId:',
            'bind' => array('reportId' => $model->id)
        ));

        $tireModel = HdUserAutoReportTire::find(array(
            'conditions' => 'report_id=:reportId:',
            'bind' => array('reportId' => $model->id)
        ));

        $otherModel = HdUserAutoReportOther::findFirst(array(
            'conditions' => 'report_id=:reportId:',
            'bind' => array('reportId' => $model->id)
        ));


        if ($this->request->getPost()) {


            if (!$modelExist) {
                return $this->refresh();
            }
            /**
             * report_lights
             */
            try {


                $this->db->begin();
                $model->update_time = date('Y-m-d H:i:s');
                $model->save();

                $order->status = OrderComponent::STATUS_ASSIGN_FEEDBACK;
                $order->service_time = date('Y-m-d H:i:s');
                $order->save();

                /**
                 * 使用商品
                 *
                 * 只能修改其评价，不能修改商品使用情况；好像他妈的不合理，，
                 */
                $this->updateUseProducts($order);

                $report_lights = $this->saveLights($model,$lightModel);
                $report_oilFilterBattery = $this->saveOilFilterBattery($model,$oilFilterBatteryModel);
                $report_tire = $this->saveTire($model,$tireModel);
                $report_other = $this->saveOther($model,$otherModel);


                $summaryObject =  HdUserAutoReportSummary::findFirst(array(
                    'conditions'=>'report_id=:reportId: and order_id=:orderId:',
                    'bind'=>array('reportId'=>$model->id,'orderId'=>$order->id)
                ));

                $summaryObject->appearance_lighting = $report_lights;
                $summaryObject->oil_filter_battery = $report_oilFilterBattery;
                $summaryObject->tire_brake = $report_tire;
                $summaryObject->other = $report_other;
                $summaryObject->total = floor(0.25 * $report_lights + 0.3 * $report_oilFilterBattery + 0.3 * $report_tire + 0.15 * $report_other);
                $summaryObject->save();
                $this->db->commit();
                $this->flash->success('保存成功');
            } catch (Exception $e) {
                $this->flash->error('保存失败');
                $this->db->rollback();

            }


//            return $this->refresh();
        }


        $this->view->setVar('order', $order);
        $this->view->setVar('orderLinkman', $order->getLinkman());
        $this->view->setVar('orderAuto', $order->getAuto());
        $this->view->setVar('orderAddress', $order->getAddress());
        $this->view->setVar('model', $model);
        $this->view->setVar('lightModel', $lightModel);
        $this->view->setVar('oilFilterBatteryModel', $oilFilterBatteryModel);
        $this->view->setVar('tireModel', $tireModel);
        $this->view->setVar('otherModel', $otherModel);
    }

    protected function useProducts()
    {
        $products = $this->request->getPost('products', \Phalcon\Filter::FILTER_INT);
        if (!empty($products)) {
            $productsModel = HdOrderProduct::find(array(
                'conditions' => 'id in (id:{array})',
                'bind' => array($products)
            ));
            foreach ($productsModel as $p) {
                $p->active = 1;
                $p->save();
                unset($p);
            }
        }
    }
    protected function updateUseProducts($orderModel){

        $orderProductsIdArray = $postProductsIdArray = $resetProductsIdArray =  array();
        $orderProducts = HdOrderProduct::find(array(
            'conditions'=>'order_id=:orderId:',
            'bind'=>array('orderId'=>$orderModel->id)
        ));
        foreach($orderProducts as $p){
            $orderProductsIdArray[]=$p->id;
        }


        $products = $this->request->getPost('products', \Phalcon\Filter::FILTER_INT);
        if (!empty($products)) {
            $productsModel = HdOrderProduct::find(array(
                'conditions' => 'id in (id:{array})',
                'bind' => array($products)
            ));
            foreach($orderProducts as $p){
                $postProductsIdArray[]=$p->id;
            }

            $resetProductsIdArray = array_diff($orderProductsIdArray,$postProductsIdArray);

            if(!empty($resetProductsIdArray)){
                $resetProducts = HdOrderProduct::find(array(
                    'conditions' => 'id in (id:{array})',
                    'bind' => array($products)
                ));
                foreach($resetProducts as $p){
                    $p->active = 0;
                    $p->save();
                    unset($p);
                }
            }

            foreach ($productsModel as $p) {
                $p->active = 1;
                $p->save();
                unset($p);
            }
        }
    }

    /**
     * 总分
     * @return float 灯总分
     */
    protected function saveLights($model, $object = null)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['far_light'] = $this->request->getPost('far_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['near_light'] = $this->request->getPost('near_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['turn_light'] = $this->request->getPost('turn_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['brake_light'] = $this->request->getPost('brake_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['fog_light'] = $this->request->getPost('fog_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['small_light'] = $this->request->getPost('small_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['reversing_light'] = $this->request->getPost('reversing_light', \Phalcon\Filter::FILTER_FLOAT);

        if (is_null($object)) {
            $object = new HdUserAutoReportLight();
            $object->report_id = $model->id;
            $object->order_id = $model->order_id;
        }

        foreach ($array as $k => $v) {
            $object->$k = $v;
        }
        $object->save();

        return $this->getSummary($array);

    }

    protected function saveOilFilterBattery($model, $object = null)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['spare_tire'] = $this->request->getPost('spare_tire', \Phalcon\Filter::FILTER_FLOAT);
        $array['engine_oil_callout'] = $this->request->getPost('engine_oil_callout', \Phalcon\Filter::FILTER_FLOAT);
        $array['engine_oil_old_analyzing'] = $this->request->getPost('engine_oil_old_analyzing', \Phalcon\Filter::FILTER_FLOAT);
        $array['air_filter'] = $this->request->getPost('air_filter', \Phalcon\Filter::FILTER_FLOAT);
        $array['air_conditioning_filter'] = $this->request->getPost('air_conditioning_filter', \Phalcon\Filter::FILTER_FLOAT);
        $array['antifreeze_freezing'] = $this->request->getPost('antifreeze_freezing', \Phalcon\Filter::FILTER_FLOAT);
        $array['antifreeze_visual'] = $this->request->getPost('antifreeze_visual', \Phalcon\Filter::FILTER_FLOAT);
        $array['antifreeze_level'] = $this->request->getPost('antifreeze_level', \Phalcon\Filter::FILTER_FLOAT);
        $array['steering_oil_visual'] = $this->request->getPost('steering_oil_visual', \Phalcon\Filter::FILTER_FLOAT);
        $array['steering_oil_level'] = $this->request->getPost('steering_oil_level', \Phalcon\Filter::FILTER_FLOAT);
        $array['transmission_oil_visual'] = $this->request->getPost('transmission_oil_visual', \Phalcon\Filter::FILTER_FLOAT);
        $array['transmission_oil_level'] = $this->request->getPost('transmission_oil_level', \Phalcon\Filter::FILTER_FLOAT);
        $array['glass_water'] = $this->request->getPost('glass_water', \Phalcon\Filter::FILTER_FLOAT);
        $array['battery_appearance'] = $this->request->getPost('battery_appearance', \Phalcon\Filter::FILTER_FLOAT);
        $array['battery_charge_level'] = $this->request->getPost('battery_charge_level', \Phalcon\Filter::FILTER_FLOAT);
        $array['battery_health_index'] = $this->request->getPost('battery_health_index', \Phalcon\Filter::FILTER_FLOAT);
        $array['battery_pile'] = $this->request->getPost('battery_pile', \Phalcon\Filter::FILTER_FLOAT);
        $array['battery_led_color'] = $this->request->getPost('battery_led_color', \Phalcon\Filter::FILTER_FLOAT);
        $array['hoses_lines'] = $this->request->getPost('hoses_lines', \Phalcon\Filter::FILTER_FLOAT);

        if (is_null($object)) {
            $object = new HdUserAutoReportOilFilter();
            $object->report_id = $model->id;
            $object->order_id = $model->order_id;
        }

        foreach ($array as $k => $v) {
            $object->$k = $v;
        }
        $object->save();

        return $this->getSummary($array);
    }

    protected function saveTire($model, $object = null)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['pressure'] = $this->request->getPost('pressure', \Phalcon\Filter::FILTER_FLOAT);
        $array['factory_day_checkable'] = $this->request->getPost('factory_day_checkable', \Phalcon\Filter::FILTER_FLOAT);
        $array['factory_day'] = $this->request->getPost('factory_day', \Phalcon\Filter::FILTER_FLOAT);
        $array['tread_depth'] = $this->request->getPost('tread_depth', \Phalcon\Filter::FILTER_FLOAT);
        $array['aging'] = $this->request->getPost('aging', \Phalcon\Filter::FILTER_FLOAT);
        $array['tread'] = $this->request->getPost('tread', \Phalcon\Filter::FILTER_FLOAT);
        $array['sidewall'] = $this->request->getPost('sidewall', \Phalcon\Filter::FILTER_FLOAT);
        $array['brake_pads_checkable'] = $this->request->getPost('brake_pads_checkable', \Phalcon\Filter::FILTER_FLOAT);
        $array['brake_pads_thickness'] = $this->request->getPost('brake_pads_thickness', \Phalcon\Filter::FILTER_FLOAT);
        $array['brake_dish'] = $this->request->getPost('brake_dish', \Phalcon\Filter::FILTER_FLOAT);

        if(is_null($object)){
            foreach ($array['pressure'] as $key => $val) {
                $object = new HdUserAutoReportTire();
                $object->report_id = $model->id;
                $object->order_id = $model->order_id;
                $object->position = $key;
                foreach ($array as $k => $v) {
                    $object->$k = $v[$key];
                }
                $object->save();
            }
        }else{
            foreach ($array['pressure'] as $key => $val) {
                //循环对象
                foreach($object as $row){
                    if($key == $row->position){
                        foreach ($array as $k => $v) {
                            $row->$k = $v[$key];
                        }
                        $row->save();
                    }
                }

            }
        }

        return $this->getTireSummary($array);
    }


    protected function saveOther($model, $object = null)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['wipers_front'] = $this->request->getPost('wipers_front', \Phalcon\Filter::FILTER_FLOAT);
        $array['wipers_rear'] = $this->request->getPost('wipers_rear', \Phalcon\Filter::FILTER_FLOAT);
        $array['fire_extinguisher'] = $this->request->getPost('fire_extinguisher', \Phalcon\Filter::FILTER_FLOAT);
        $array['warning_sign'] = $this->request->getPost('warning_sign', \Phalcon\Filter::FILTER_FLOAT);

        if (is_null($object)) {
            $object = new HdUserAutoReportOther();
            $object->report_id = $model->id;
            $object->order_id = $model->order_id;
        }

        foreach ($array as $k => $v) {
            $object->$k = $v;
        }
        $object->save();
        return $this->getSummary($array);
    }

    protected function getSummary($array)
    {
        if (!count($array)) {
            return 0;
        }
        return $summary = floor((array_sum($array) / count($array)) * 100);
    }

    protected function getTireSummary($array)
    {
        if (!count($array)) {
            return 0;
        }


//        exit;
        $tempArray = array();
        $tempNumber = 0;
        for ($i = 1; $i < 5; $i++) {
            foreach ($array as $k => $v) {
                if (isset($v[$i]))
                    $tempArray[$i][] = $v[$i];
            }
        }


        foreach ($tempArray as $v) {
            $tempNumber += $this->getSummary($v);
        }

        return floor($tempNumber / count($tempArray));
    }


}