<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 15/10/8
 * Time: 23:31
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 15/10/8  Time: 23:31
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

use Phalcon\Paginator\Adapter\Model as Paginator;

class UserController extends ControllerBase
{


    function initialize(){
        parent::initialize();
        if (!$this->session->get('auth')) {
            return $this->response->redirect("index/login?reUrl=user/".$this->dispatcher->getActionName());
        }

        $this->view->setVar('actionName',$this->dispatcher->getActionName());
    }


    function indexAction(){

        $auth = $this->session->get('auth');

        $linkman = HdUserLinkman::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            ),
            'order'=>'id desc'
        ));
        $linkAddress = HdUserAddress::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            ),
            'order'=>'id desc'
        ));
        $carInfo = HdUserAuto::findFirst(array(
            'conditions'=>'user_id=:userId:',
            'bind'=>array(
                'userId'=>$auth->id
            ),
            'order'=>'id desc'
        ));
        $modelExact = HdAutoModelsExact::findFirst($carInfo->models);

        $this->view->setVar('auth',$auth);
        $this->view->setVar('userData',$auth);
        $this->view->setVar('linkman',$linkman);
        $this->view->setVar('linkAddress',$linkAddress);
        $this->view->setVar('carInfo',$carInfo);
        $this->view->setVar('modelExact',$modelExact);
    }

    function editAction(){




        if($this->request->isPost()){


            /**
             * 新加入过滤
             */
            $mobile = $this->request->getPost('mobile', \Phalcon\Filter::FILTER_FLOAT);
            $name = $this->request->getPost('name', \Phalcon\Filter::FILTER_STRING);
            $address = $this->request->getPost('address', \Phalcon\Filter::FILTER_STRING);
            $carnum = $this->request->getPost('carnum', \Phalcon\Filter::FILTER_STRING);
            $exact_id = $this->request->getPost('inputAutoModelExact', \Phalcon\Filter::FILTER_STRING);
            $linkman_id = $this->request->getPost('linkmanId', \Phalcon\Filter::FILTER_STRING);
            $linkAddress_id = $this->request->getPost('linkAddressId', \Phalcon\Filter::FILTER_STRING);

            $carid = $this->request->getPost('carId',\Phalcon\Filter::FILTER_FLOAT);
            $inputAutoModelExact = $this->request->getPost('inputAutoModelExact',\Phalcon\Filter::FILTER_FLOAT);
            //todo 没有做 提交空信息处理；；
            //todo 没有过滤手机号码；
            //todo 大爷的，通宵改bug；；
            $auth  = $this->session->get('auth');
            $mobile=$auth->mobile;
            if (!preg_match('/^1[3-9]{1}[0-9]{9}$/', $mobile)) {
                $this->flash->error("手机格式不正确");
                return $this->response->redirect('user/index');
            }
            if (empty($name)) {
                $this->flash->error("姓名不能为空");
                return $this->response->redirect('user/index');
            }
            if (empty($address)) {
                $this->flash->error("地址不能为空");
                return $this->response->redirect('user/index');
            }
            if (empty($carnum)) {
                $this->flash->error("车牌号不能为空");
                return $this->response->redirect('user/index');
            }
            $auth = $this->session->get('auth');
            $data = array(
                'mobile'=>$mobile,'name'=>$name,'address'=>$address,'carnum'=>$carnum,'carid'=>$carid,
                'modelsExact_id'=>$exact_id,'user_id'=>$auth->id,'linkman_id'=>$linkman_id,'linkAddress_id'=>$linkAddress_id
            );

            $fileLogger = new Phalcon\Logger\Adapter\File(APP_PATH.'/cache/interface.log');
            $fileLogger->log('request',json_encode($data));
            $response  = $this->restful->post('http://api.handao365.dev/user/edit',$data);
            $fileLogger->log('response',$response);

            $json = json_decode($response,true);
            if($json['statusCode']=='000000'){
                return $this->response->redirect('/user/index');
            }else{
                return $this->response->redirect('/user/edit');
            }


            return $this->refresh();
        }

        $this->indexAction();

        $modelExact = $this->view->getVar('modelExact');

        $brandsComponent = new BrandsComponent();
        $brands = $brandsComponent->getAutoBrands();
        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $modelExact->brands_id)
        ));

        $autoModelsExacts = HdAutoModelsExact::find(array(
            'conditions' => 'models_id=:modelsId:',
            'bind' => array('modelsId' => $modelExact->models_id)
        ));



        $this->view->setVar('brands',$brands);
        $this->view->setVar('autoModels',$autoModels);
        $this->view->setVar('autoModelsExacts',$autoModelsExacts);


    }


    public function waitAction()
    {



        $user_id = $this->session->get('auth')->id;
        $numberPage = $this->request->getQuery("page", "int");
        $paginator = new Paginator(array(
            "data" => HdOrder::find(
                array(
                    "conditions" => "user_id = :user_id: and status in (11,12,21,22,23,24)",
                    "bind" => array('user_id' => $user_id),
                    'order' => 'id desc'
                )),
            "limit" => 10,
            "page" => $numberPage,
        ));
        $userData = $this->session->get('auth');
        $this->view->setMainView('record');
        $this->view->setVar('userData', $userData);
        $this->view->setVar('page', $paginator->getPaginate());
    }



    public function finishAction()
    {

        $user_id = $this->session->get('auth')->id;
        $numberPage = $this->request->getQuery("page", "int");
        $paginator = new Paginator(array(
            "data" => HdOrder::find(
                array(
                    "conditions" => "user_id = :user_id: and status =:status:",
                    "bind" => array('user_id' => $user_id, 'status' => OrderComponent::STATUS_RESULT_SUCCESS),
                    'order' => 'id desc'
                )),
            "limit" => 10,
            "page" => $numberPage,
        ));
        $userData = $this->session->get('auth');
        $this->view->setMainView('record');
        $this->view->setVar('userData', $userData);
        $this->view->setVar('page', $paginator->getPaginate());
    }
}