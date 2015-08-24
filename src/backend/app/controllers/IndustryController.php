<?php

class IndustryController extends ControllerBase
{

    public function indexAction()
    {
        $dispatcher = $this->dispatcher;
        return $dispatcher->forward(array(
            'controller' => 'industry',
            'action' => 'list',
            'params' => $dispatcher->getParams()
        ));
    }

    public function listAction()
    {
        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => HdIndustry::find(),
            'page' => $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT),
            'limit' => $this->config->paginate->limit
        ));
        $this->view->setVar('paginate', $paginate->getPaginate());
    }

    public function createAction()
    {
        if ($this->request->isPost()) {
            $name = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $description = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);

            if (empty($name)) {
                $this->flash->error('请输入完整的名称');
                return $this->refresh();
            }
            $model = new HdIndustry();
            $model->name = $name;
            $model->description = $description;

            if ($model->save()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            return $this->refresh();
        }
    }

    public function updateAction($id)
    {
        $model = $this->_getModel($id);
        if ($this->request->isPost()) {
            $id = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $name = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $description = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);

            if($id != $model->id){
                $this->flash->error('提交信息与原始数据不匹配');
                return $this->refresh();
            }
            if (empty($name) ) {
                $this->flash->error('请输入完整的名称');
                return $this->refresh();
            }

            $model->name = $name;
            $model->description = $description;

            if ($model->save()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            return $this->refresh();
        }
        $this->view->setVar('model',$model);
    }

    public function delete($id){
        throw new \Phalcon\Exception('删除功能尚未启用');
    }

    protected function _getModel($id)
    {
        $model = HdIndustry::findFirst($id);
        if(!$model){
            throw new \Phalcon\Exception('');
        }
        return $model;
    }


}

