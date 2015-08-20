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
        //分页设置
        $numberPage = $this->request->getQuery("page", "int");
        $paginator = new Paginator(array(
            "data" => HdUser::find(),
            "limit" => 1,
            "page" => $numberPage,

        ));
        $this->view->setVar('page', $paginator->getPaginate());

    }

    public function updateAction()
    {
        echo 'taohs';
    }

    public function deleteAction()
    {
            echo 222;
        echo 333;
    }

    public function linkmanAction($id=null)
    {
        // $data=HdUserLinkman::find()->toArray();


        $this->view->setVar('data',HdUserLinkman::find());
    }

}

