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
        if ($this->session->get( 'auth' )) {
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
                if ($user) {
                     if ($user && $this->security->checkHash( $code, $user->password )) {
                         $this->session->set( 'auth', $user );
                         return $this->response->redirect( $reUrl );
                     } else {
                         $this->flash->error( "验证码不正确" );
                     }
                 }

            } else {
                $this->flash->error( "验证码不正确" );
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
                    "bind"       => array( 'user_id' => $user_id, 'status' => OrderComponent::STATUS_RESULT_SUCCESS ),
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
        $mobile = $this->request->getPost( 'mobile' );
        $post_data = array( "mobile" => $mobile );

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $this->loginCodeUrl );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

        curl_setopt( $ch, CURLOPT_POST, 1 );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );

        $output = curl_exec( $ch );
        curl_close( $ch );


        var_dump( json_decode($output) );

    }


    public function logoutAction()
    {
        $this->session->remove( 'auth' );
        return $this->response->redirect( 'index/index' );
    }
    public function

}

