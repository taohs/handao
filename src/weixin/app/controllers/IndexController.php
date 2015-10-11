<?php
use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        //$this->session->set('auth','');
    }

    function captchaAction()
    {

        $this->view->disable();
        //先把类包含进来，实际路径根据实际情况进行修改。
        $_vc = new ValidateCode();  //实例化一个对象
        $_vc->doimg();
        $this->session->set('authnum_session', $_vc->getCode());
    }

    function checkCaptchaAction(){
        if (isset($_POST["inputCode"])) {
            $validate = $_POST["inputCode"];

            if ($validate != $this->session->get("authnum_session")) {
//判断session值与用户输入的验证码是否一致;
//                        echo "<font color=red>输入有误</font>";
                echo json_encode(array('rel'=>false));
            } else {
                echo json_encode(array('rel'=>true));
//                        echo "<font color=green>通过验证</font>";
            }
        }
        return null;
    }

    public function loginAction()
    {
        if ($this->session->get('auth')) {
            return $this->response->redirect("index");
        }
        $reUrl = $this->request->getQuery('reUrl');
        if ($this->request->isPost()) {
            if ($this->security->checkToken($this->session->get('$PHALCON/CSRF/KEY$'), $this->security->getSessionToken())) {
                if (isset($_POST["inputCode"])) {
                    $validate = $_POST["inputCode"];
                /**
                 * 取消登录图形验证码；
                 */
//                    if ($validate != $this->session->get("authnum_session")) {
//                    //判断session值与用户输入的验证码是否一致;
//                        $this->flash->error('验证码错误');
//                        return $this->refresh();
//                    }
                }


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
        $this->view->setMainView('record');

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
        if (isset($_POST["captcha"])) {
            $validate = $_POST["captcha"];

            if ($validate != $this->session->get("authnum_session")) {
//判断session值与用户输入的验证码是否一致;
//                        echo "<font color=red>输入有误</font>";
               echo json_encode(array('statusCode'=>1000,'statusMsg'=>'图形验证码输入错误'));
              exit;
            }
        }
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