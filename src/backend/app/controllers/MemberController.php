<?php
use Phalcon\Paginator\Adapter\Model as Paginator;
class MemberController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect( $this->dispatcher->getControllerName() . '/list' );
    }

    /**
     * 会员列表
     */
    public function listAction()
    {
        $this->view->setVar('data',HdUser::find());
        $this->view->setVar('b',0);
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {

    }

    public function linkmanAction($id=null)
    {
        // $data=HdUserLinkman::find()->toArray();


        $this->view->setVar('data',HdUserLinkman::find());
    }

}

