<?php

class ProductsController extends  ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction(){
        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data'=>HdProduct::find(),
            'page'=>$this->request->getQuery('page',\Phalcon\Filter::FILTER_INT),
            'limit'=>$this->config->paginate->limit
        ));
        $this->view->setVar('paginate',$paginate->getPaginate());
    }

    public function createAction(){
        $model = new HdProduct();

        $this->view->setVar('model',$model);
    }
    public function updateAction($id){
        $model = $this->_getModel($id);


        $this->view->setVar('model',$model);
    }
    public function deleteAction($id){
        $model = $this->_getModel($id);

    }
    protected function _getModel($id){
        $model = HdProduct::findFirst($id);
        if(!$model){
            throw new \Phalcon\Exception("id 错误");
        }
        return $model;
    }

}

