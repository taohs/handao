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
        $auth = $this->session->get('auth');
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
                    $this->session->set('auth', $worker);
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
        $this->session->remove('auth');
    }

    /**
     * 工作台 订单列表
     */
    function dashboardAction()
    {
        echo 1;
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

        if ($this->request->getPost()) {

            /**
             * report_lights
             */
            try{


            $this->db->begin();
            $model->auto_id = $order->auto_id;
            $model->order_id = $order->id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->save();

            $report_lights = $this->saveLights($model);
            $report_oilFilterBattery = $this->saveOilFilterBattery($model);
            $report_tire = $this->saveTire($model);
            $report_other = $this->saveOther($model);

                $this->db->commit();
            }catch (Exception $e){
                $this->db->rollback();
            }


            return $this->refresh();
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
    function updateReportAction()
    {

    }

    /**
     * 总分
     * @return float 灯总分
     */
    protected function saveLights($model)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['far_lights'] = $this->request->getPost('far_lights', \Phalcon\Filter::FILTER_FLOAT);
        $array['rear_lights'] = $this->request->getPost('rear_lights', \Phalcon\Filter::FILTER_FLOAT);
        $array['turn_light'] = $this->request->getPost('turn_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['brake_light'] = $this->request->getPost('brake_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['fog_light'] = $this->request->getPost('fog_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['small_light'] = $this->request->getPost('small_light', \Phalcon\Filter::FILTER_FLOAT);
        $array['reversing_light'] = $this->request->getPost('reversing_light', \Phalcon\Filter::FILTER_FLOAT);

        $object =new HdUserAutoReportLight();
        $object->report_id = $model->id;
        $object->order_id  = $model->order_id;
        foreach($array as $k=>$v){
            $object->$k = $v;
        }
        $object->save();

        return $this->getSummary($array);

    }

    protected function saveOilFilterBattery($model)
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

        $object =new HdUserAutoReportOilFilter();
        $object->report_id = $model->id;
        $object->order_id  = $model->order_id;
        foreach($array as $k=>$v){
            $object->$k = $v;
        }
        $object->save();

        return $this->getSummary($array);
    }

    protected function saveTire($model)
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

        $object =new HdUserAutoReportTire();
        $object->report_id = $model->id;
        $object->order_id  = $model->order_id;
        foreach($array as $k=>$v){
            $object->$k = $v;
        }
        $object->save();

        return $this->getSummary($array);
    }


    protected function saveOther($model)
    {
        /**
         * report_lights
         */
        $array = array();
        $array['wipers_front'] = $this->request->getPost('wipers_front', \Phalcon\Filter::FILTER_FLOAT);
        $array['wipers_rear'] = $this->request->getPost('wipers_rear', \Phalcon\Filter::FILTER_FLOAT);
        $array['fire_extinguisher'] = $this->request->getPost('fire_extinguisher', \Phalcon\Filter::FILTER_FLOAT);
        $array['warning_sign'] = $this->request->getPost('warning_sign', \Phalcon\Filter::FILTER_FLOAT);

        $object =new HdUserAutoReportOther();
        $object->report_id = $model->id;
        $object->order_id  = $model->order_id;
        foreach($array as $k=>$v){
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


}