<?php
use Phalcon\Paginator\Adapter\Model as Paginator;
class TechnicianController extends ControllerBase
{
    public $pageLimit = 10;

    public function indexAction()
    {
        return $this->response->redirect( $this->dispatcher->getControllerName() . '/list' );
    }

    public function listAction()
    {
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => HdTechnician::find( array( 'order' => 'id desc' ) ),
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );
    }
    public function updateUserAction( $id = null )
    {
        $user = array();
        if ($id) {
            $user = HdTechnician::findFirst( array(
                "conditions" => "id = :id:",
                "bind"       => array( 'id' => $id )
            ) );
        }
        if (! $user) {
            $user['username'] = '';
            $user['mobile'] = '';
            $user['email'] = '';
            $user['id'] = '';
            $user['name'] = '';
            $user = (object)$user;
        }
        $form = new UpdateUserForm();
        if ($this->request->isPost()) {
            $mobile = $this->request->getPost( 'mobile' );
            $username = $this->request->getPost( 'username' );
            $email = $this->request->getPost( 'email', 'email' );
            $uid = $this->request->getPost( 'id' );
            $name = $this->request->getPost( 'name' );
            if(!$mobile){
                $this->flash->error( '电话必须填写' );
                return  $this->response->redirect( '/technician/updateuser/' . $uid );
            }else{
                $mobileData = HdTechnician::findFirst( array(
                    "conditions" => "mobile = :mobile:",
                    "bind"       => array( 'mobile' => $mobile )
                ) );
            }
            $user = new HdTechnician();
            if ($uid) {
                $user->id = $uid;
                if ($mobileData && $uid != $mobileData->id) {
                    $this->flash->error( '电话已存在' );
                    return      $this->response->redirect( '/technician/updateuser/' . $uid );
                }
            } else {
                $user->create_time = date( "Y-m-d H:i:s" );
                if ($mobileData) {
                    $this->flash->error( '电话已存在' );
                    return     $this->response->redirect( '/technician/updateuser/' . $uid );

                }
            }
            $user->username = $username;
            $user->password = $this->security->hash($mobile);
            $user->mobile = $mobile;
            $user->email = $email;
            $user->role = 1;
            $user->update_time = date( "Y-m-d H:i:s" );
            $user->name = $name;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error( (string)$message );
                }
            } else {
                $this->flash->success( '成功' );
                return    $this->response->redirect( '/technician/list/' );
            }
        }
        $this->view->setVar( 'form', $form );
        $this->view->setVar( 'user', $user );

    }
}

