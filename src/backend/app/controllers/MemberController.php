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
            "data"  => HdUser::find(array( 'order'=>'id desc')),
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

    /**
     * @todo 1个用户 有多个联系人 ，多个地址 多个车（每个车有多次养护报告），4个分别的列表
     * @param null $id
     */
    public function linkmanAction( $id = null )
    {
        $linkman= HdUserLinkman::find( array(
            "conditions" => "user_id = :id:",
            "bind" => array('id' => $id),
            'order'=>'id desc'
        ) );
        //分页设置
        $numberPage = $this->request->getQuery( "page", "int" );
        $paginator = new Paginator( array(
            "data"  => $linkman,
            "limit" => $this->pageLimit,
            "page"  => $numberPage,

        ) );
        $this->view->setVar( 'page', $paginator->getPaginate() );


    }

}

