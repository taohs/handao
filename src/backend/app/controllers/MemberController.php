<?php
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemberController extends ControllerBase
{
    public $pageLimit = 10;

    public function indexAction()
    {
        return $this->response->redirect( $this->dispatcher->getControllerName() . '/list' );
    }

    /**
     * 会员列表
     */
    public function listAction()
    {
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => HdUser::find( array( 'order' => 'id desc' ) ),
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );

    }

    public function updateUserAction( $id = null )
    {
        $user = array();
        if ($id) {
            $user = HdUser::findFirst( array(
                "conditions" => "id = :id:",
                "bind"       => array( 'id' => $id )
            ) );
        }
        if (! $user) {
            $user['username'] = '';
            $user['mobile'] = '';
            $user['email'] = '';
            $user['id'] = '';
            $user = (object)$user;
        }
        $form = new UpdateUserForm();
        if ($this->request->isPost()) {
            $mobile = $this->request->getPost( 'mobile' );
            $username = $this->request->getPost( 'username' );
            $email = $this->request->getPost( 'email', 'email' );
            $uid = $this->request->getPost( 'id' );

            if (! $mobile) {
                $this->flash->error( '电话必须填写' );
                return $this->response->redirect( '/member/updateuser/' . $uid );
            } else {
                $mobileData = HdUser::findFirst( array(
                    "conditions" => "mobile = :mobile:",
                    "bind"       => array( 'mobile' => $mobile )
                ) );
            }
            $user = new HdUser();
            if ($uid) {
                $user->id = $uid;
                if ($mobileData && $uid != $mobileData->id) {
                    $this->flash->error( '电话已存在' );
                    return  $this->response->redirect( '/member/updateuser/' . $uid );
                }
            } else {
                $user->create_time = date( "Y-m-d H:i:s" );
                if ($mobileData) {
                    $this->flash->error( '电话已存在' );
                    return   $this->response->redirect( '/member/updateuser/' . $uid );

                }
            }
            $user->username = $username;
            $user->password = $this->security->hash( $mobile );
            $user->mobile = $mobile;
            $user->email = $email;
            $user->update_time = date( "Y-m-d H:i:s" );
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error( (string)$message );
                }
            } else {
                $this->flash->success( '成功' );
                $this->response->redirect( '/member/list/' );
            }
        }
        $this->view->setVar( 'form', $form );
        $this->view->setVar( 'user', $user );

    }

    public function deleteAction()
    {

    }

    /**
     *
     *
     * @param null $id
     */
    public function linkmanAction( $id = null )
    {
        $linkman = HdUserLinkman::find( array(
            "conditions" => "user_id = :id:",
            "bind"       => array( 'id' => $id ),
            'order'      => 'id desc'
        ) );
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => $linkman,
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );
        $this->view->setVar( 'user_id', $id );

    }

    public function addressAction( $id = null )
    {
        $address = HdUserAddress::find( array(
            "conditions" => "user_id = :id:",
            "bind"       => array( 'id' => $id ),
            'order'      => 'id desc'
        ) );
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => $address,
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );
        $this->view->setVar( 'user_id', $id );

    }

    public function autoAction( $id = null )
    {
        $auto = HdUserAuto::find( array(
            "conditions" => "user_id = :id:",
            "bind"       => array( 'id' => $id ),
            'order'      => 'id desc'
        ) );
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => $auto,
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );

        $this->view->setVar( 'user_id', $id );
    }

    public function updateLinkmanAction( $id = null )
    {
        $id = $this->request->getQuery( 'id' );
        $user_id = $this->request->getQuery( 'user_id' );
        $user = array();
        if ($id) {
            $user = HdUserLinkman::findFirst( array(
                "conditions" => "id = :id:",
                "bind"       => array( 'id' => $id )
            ) );
        }
        if (! $user) {
            $user['name'] = '';
            $user['mobile'] = '';
            $user['id'] = '';
            $user['user_id'] = '';
            $user = (object)$user;
        }
        $form = new UpdateUserForm();
        if ($this->request->isPost()) {
            $mobile = $this->request->getPost( 'mobile' );
            $name = $this->request->getPost( 'name' );
            $id = $this->request->getPost( 'id' );
            $user_id = $this->request->getPost( 'user_id' );

            $user = new HdUserLinkman();
            if ($id) {
                $user->id = $id;
            }
            $user->name = $name;
            $user->mobile = $mobile;
            $user->user_id = $user_id;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error( (string)$message );
                }
            } else {
                $this->flash->success( '成功' );
                return     $this->response->redirect( '/member/linkman/' . $user_id );
            }
        }
        $this->view->setVar( 'form', $form );
        $this->view->setVar( 'user', $user );
        $this->view->setVar( 'user_id', $user_id );

    }

    public function updateAddressAction( $id = null )
    {
        $id = $this->request->getQuery( 'id' );
        $user_id = $this->request->getQuery( 'user_id' );
        $user = array();
        if ($id) {
            $user = HdUserAddress::findFirst( array(
                "conditions" => "id = :id:",
                "bind"       => array( 'id' => $id )
            ) );
        }
        if (! $user) {
            $user['address'] = '';
            $user['province'] = '';
            $user['city'] = '';
            $user['area'] = '';
            $user['id'] = '';
            $user['user_id'] = '';
            $user = (object)$user;
        }
        $form = new UpdateUserForm();
        if ($this->request->isPost()) {
            $address = $this->request->getPost( 'address' );
            $province = $this->request->getPost( 'province' );
            $city = $this->request->getPost( 'city' );
            $area = $this->request->getPost( 'area' );


            $id = $this->request->getPost( 'id' );
            $user_id = $this->request->getPost( 'user_id' );

            $user = new HdUserAddress();
            if ($id) {
                $user->id = $id;
            }
            $user->address = $address;
            $user->province = $province;
            $user->city = $city;
            $user->area = $area;
            $user->user_id = $user_id;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error( (string)$message );
                }
            } else {
                $this->flash->success( '成功' );
                return   $this->response->redirect( '/member/address/' . $user_id );
            }
        }
        $this->view->setVar( 'form', $form );
        $this->view->setVar( 'user', $user );
        $this->view->setVar( 'user_id', $user_id );

    }


    public function updateAutoAction( $id = null )
    {
        $id = $this->request->getQuery( 'id' );
        $user_id = $this->request->getQuery( 'user_id' );
        $user = array();
        if ($id) {
            $user = HdUserAuto::findFirst( array(
                "conditions" => "id = :id:",
                "bind"       => array( 'id' => $id )
            ) );
        }
        if (! $user) {
            $user['license'] = '';
            $user['number'] = '';
            $user['models'] = '';
            $user['year'] = '';
            $user['id'] = '';
            $user['user_id'] = '';
            $user = (object)$user;
        }
        $form = new UpdateUserForm();
        if ($this->request->isPost()) {
            $license = $this->request->getPost( 'license' );
            $number = $this->request->getPost( 'number' );
            $models = $this->request->getPost( 'models' );
            $year = $this->request->getPost( 'year' );


            $id = $this->request->getPost( 'id' );
            $user_id = $this->request->getPost( 'user_id' );

            $user = new HdUserAuto();
            if ($id) {
                $user->id = $id;
            }
            $user->license = $license;
            $user->number = $number;
            $user->models = $models;
            $user->year = $year;
            $user->user_id = $user_id;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error( (string)$message );
                }
            } else {
                $this->flash->success( '成功' );
                return   $this->response->redirect( '/member/auto/' . $user_id );
            }
        }
        $this->view->setVar( 'form', $form );
        $this->view->setVar( 'user', $user );
        $this->view->setVar( 'user_id', $user_id );

    }

}

