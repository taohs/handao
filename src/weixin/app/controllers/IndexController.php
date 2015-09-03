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
        if ( $this->session->get( 'auth' )) {
            return $this->response->redirect( "index" );
        }
        $reUrl = $this->request->getQuery( 'reUrl' );
        if ($this->request->isPost()) {

            if ($this->security->checkToken( $this->session->get( '$PHALCON/CSRF/KEY$' ), $this->security->getSessionToken() )) {
                $mobile = $this->request->getPost( 'mobile' );
                $code = $this->request->getPost( 'code' );
                $user = HdUser::findFirst(
                    array(
                        'conditions' => 'mobile=:mobile:',
                        'bind'       => array(
                            'mobile' => $mobile,
                        )
                    ) );
                if ($this->userRegister( $user, $mobile )) {

                    if ($user && $this->security->checkHash( $code, $user->password )) {
                        $this->session->set( 'auth', $user );
                        return $this->response->redirect( $reUrl );
                    } else {
                        $this->flash->error( "验证码不正确" );
                    }
                }

            } else {

                $this->flash->error( "token errors" );
            }

        }
    }

    public function myorderAction()
    {
        if (! $this->session->get( 'auth' )) {
            return $this->response->redirect( "index/login?reUrl=index/myorder" );
        }
        $user_id = $this->session->get( 'auth' )->id;
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => HdOrder::find(
                array(
                    "conditions" => "user_id = :user_id: and status in (11,12,21,22,23,24)",
                    "bind"       => array( 'user_id' => $user_id ),
                    'order'      => 'id desc'
                ) ),
            "limit" => 10,
            "page"  => $numberPage,

        ) );
        $userData = $this->session->get( 'auth' );
        $this->view->setVar( 'userData', $userData );
        $this->view->setVar( 'page', $paginator->getPaginate() );

    }

    public function myorderendAction()
    {
        if (! $this->session->get( 'auth' )) {
            return $this->response->redirect( "index/login?reUrl=index/myorderend" );
        }
        $user_id = $this->session->get( 'auth' )->id;
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => HdOrder::find(
                array(
                    "conditions" => "user_id = :user_id: and status =:status:",
                    "bind"       => array( 'user_id' => $user_id ,'status'=>41),
                    'order'      => 'id desc'
                ) ),
            "limit" => 10,
            "page"  => $numberPage,

        ) );
        $userData = $this->session->get( 'auth' );
        $this->view->setVar( 'userData', $userData );
        $this->view->setVar( 'page', $paginator->getPaginate() );

    }

    public function getcodeAction()
    {
        $code = mt_rand( 0, 9 ) . mt_rand( 0, 9 ) . mt_rand( 0, 9 ) . mt_rand( 0, 9 );
        /**
         * 短信发送到手机
         */
        $this->session->set( 'code', $code );

        echo $code;
        exit;

    }

    function userRegister( $user, $mobile )
    {
        $code = $this->session->get( 'code' );
        if ($user) {
            $user->password = $this->security->hash( $code );
            if ($user->save()) {
                return true;
            }

        } else {
            $HdUser = new HdUser();
            $HdUser->mobile = $mobile;
            $HdUser->username = $mobile;
            $HdUser->password = $this->security->hash( $code );
            $HdUser->update_time = date( "Y-m-d H:i:s" );
            $HdUser->create_time = date( "Y-m-d H:i:s" );
            if ($HdUser->save()) {
                return true;
            }
        }
        return false;
    }

    function logoutAction(){
        $this->session->remove('auth');
    }
}

