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

    function getAuth(){
        $auth = $this->session->get('auth');
        if($auth){
            return $auth;
        }else{
            return $this->response->redirect('worker/login');
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
        if($this->request->isPost()){
            if($this->security->checkToken()){

                $username = $this->request->getPost('username',\Phalcon\Filter::FILTER_STRING);
                $id       = $this->request->getPost('number',\Phalcon\Filter::FILTER_STRING);
                $password = $this->request->getPost('password',\Phalcon\Filter::FILTER_STRING);

                $worker = HdTechnician::findFirst($id);
                if($username == $worker->username && $this->security->checkHash($password,$worker->password)){
                    $this->session->set('auth',$worker);
                    $this->response->redirect('worker/dashboard');
                }else{
                    $this->flash->error("登录失败");
                }
            }else{
                $this->flash->error("令牌验证失效");
            }
        }
    }

    function logoutAction(){
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
    function createReportAction($oid=null)
    {
        $order = HdOrder::findFirst($oid);
        if(!$order){
            throw new \Phalcon\Exception('该订单不存在');
        }
        $auth = $this->getAuth();
        if($order->technician_id != $auth->id){
            throw new \Phalcon\Exception('该订单未指派给您');
        }


        if($this->request->getPost()){

            return $this->refresh();
        }





    }

    /**
     * 查看订单报告
     */
    function updateReportAction()
    {

    }


}