<?php
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemberController extends ControllerBase
{
    public $pageLimit=10;

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
            "data"  => HdUser::find(),
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );

    }

    public function updateAction()
    {
        echo 'taohs';
    }

    public function deleteAction()
    {

    }

    public function linkmanAction( $id = null )
    {
        $linkman= HdUserLinkman::findFirst( array(
            "conditions" => "user_id = :id:",
            "bind" => array('id' => $id),
        ) )->toArray();
        $address= HdUserAddress::findFirst( array(
            "conditions" => "user_id = :id:",
            "bind" => array('id' => $id),
        ) )->toArray();
        $data=$linkman+$address;

        $this->view->setVar( 'data', $data );
    }

}

