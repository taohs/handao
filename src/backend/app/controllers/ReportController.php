<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 15/10/11
 * Time: 14:14
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 15/10/11  Time: 14:14
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class ReportController extends ControllerBase
{
    public function indexAction($oid = null){
        return $this->dispatcher->forward(array(
            'controller'=>'report',
            'action'=>'detail',
            'params'=>$this->dispatcher->getParams(),
        ));

    }

    //所有技师可看
    //订单用户可看
    function detailAction($oid=null){




        $oid = intval($oid);
        if(is_null($oid) || empty($oid)){

            $this->flash->error("订单号错误");

            if($this->session->get('auth')){
                return $this->response->redirect('/index/index');
            }else{
                return $this->response->redirect('/worker/index');
            }

        }


        $order = HdOrder::findFirst($oid);
        if (!$order) {
            throw new \Phalcon\Exception('该订单不存在');
        }


        $modelExist = HdUserAutoReport::findFirst(array(
            'conditions' => 'order_id=:orderId:',
            'bind' => array('orderId' => $order->id)
        ));
        $model = $modelExist;

        if (!$modelExist) {
            $this->flash->error("该订单尚未提交报告");
            $this->response->redirect($this->request->getHTTPReferer());
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

        $summaryObject =  HdUserAutoReportSummary::findFirst(array(
            'conditions'=>'report_id=:reportId: and order_id=:orderId:',
            'bind'=>array('reportId'=>$model->id,'orderId'=>$order->id)
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
//todo 将用户名称和车辆名称现实于报告顶部，确认车辆信息以便查看
        $this->view->setVar('order', $order);
        $this->view->setVar('orderLinkman', $order->getLinkman());
        $this->view->setVar('orderAuto', $order->getAuto());
        $this->view->setVar('orderAddress', $order->getAddress());
        $this->view->setVar('model', $model);
        $this->view->setVar('lightModel', $lightModel);
        $this->view->setVar('oilFilterBatteryModel', $oilFilterBatteryModel);
        $this->view->setVar('tireModel', $tireModel);
        $this->view->setVar('otherModel', $otherModel);
        $this->view->setVar('summaryModel', $summaryObject);
    }
}