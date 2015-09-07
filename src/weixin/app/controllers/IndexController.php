<?php
use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        //$this->session->set('auth','');
    }

    public function loginAction()
    {
        if ($this->session->get('auth')) {
            return $this->response->redirect("index");
        }
        $reUrl = $this->request->getQuery('reUrl');
        if ($this->request->isPost()) {
            if ($this->security->checkToken($this->session->get('$PHALCON/CSRF/KEY$'), $this->security->getSessionToken())) {
                $mobile = $this->request->getPost('mobile');
                $code = $this->request->getPost('code');
                $webApi = new WebapiComponent();
                $re = $webApi->webApiLogin($mobile, $code);
                if ($re->statusCode == '000000') {
                    $this->session->set('auth', $re->content);
                    return $this->response->redirect($reUrl);
                } else {
                    $this->flash->error($re->statusMsg);
                }
            } else {
                $this->flash->error("token errors");
            }
        }
    }

    public function myorderAction()
    {


        if (!$this->session->get('auth')) {
            return $this->response->redirect("index/login?reUrl=index/myorder");
        }
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

    public function myorderendAction()
    {
        if (!$this->session->get('auth')) {
            return $this->response->redirect("index/login?reUrl=index/myorderend");
        }
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

    public function getcodeAction()
    {
        $mobile = $this->request->getPost('mobile');
        $webApi = new WebapiComponent();
        $re = $webApi->webApiGetCode($mobile);
        echo json_encode($re);
        exit;
    }

    public function logoutAction()
    {
        $this->session->remove('auth');
        return $this->response->redirect('index/index');
    }
}