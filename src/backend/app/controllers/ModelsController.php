<?php

class ModelsController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction()
    {
        $model = HdAutoModels::find();
        $page = $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT);
        $paginateModel = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $model,
            'limit' => $this->config->paginate->limit,
            'page' => $page
        ));

        $this->view->setVar('model', $model);
        $this->view->setVar('paginate', $paginateModel->getPaginate());
    }

    public function createAction()
    {
        $brands = $this->_getBrands();

        if ($this->request->isPost()) {

            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputBrands = $this->request->getPost('inputBrands', \Phalcon\Filter::FILTER_INT);
            $inputYears = $this->request->getPost('inputYears', \Phalcon\Filter::FILTER_STRING);

            if (empty($inputName) or empty($inputBrands) or empty($inputYears)) {
                $this->flash->error("信息填写未完整");
                return $this->refresh();
            }

            $model = new HdAutoModels();
            $model->name = $inputName;
            $model->brands_id = $inputBrands;
            $model->years = $inputYears;
            $model->create_time = date('Y-m-d H:i:s');
            $model->update_time = date('Y-m-d H:i:s');
            if ($model->save()) {
                $this->flash->success("保存成功");
            } else {
                $this->flash->error("保存失败");
            }
            return $this->refresh();
        }
        $this->view->setVar('brands', $brands);
    }

    public function updateAction($id)
    {

        $model = $this->_getModel($id);
        $brands = $this->_getBrands();


        if ($this->request->isPost()) {

            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputBrands = $this->request->getPost('inputBrands', \Phalcon\Filter::FILTER_INT);
            $inputYears = $this->request->getPost('inputYears', \Phalcon\Filter::FILTER_STRING);

            if($model->id != $inputId){
                $this->flash->error("非法操作");
                return $this->refresh();
            }

            if (empty($inputName) or empty($inputBrands) or empty($inputYears)) {
                $this->flash->error("信息填写未完整");
                return $this->refresh();
            }

            $model->name = $inputName;
            $model->brands_id = $inputBrands;
            $model->years = $inputYears;
            $model->update_time = date('Y-m-d H:i:s');
            if ($model->save()) {
                $this->flash->success("保存成功");
            } else {
                $this->flash->error("保存失败");
            }
            return $this->refresh();
        }
        $this->view->setVar('brands', $brands);
        $this->view->setVar('model', $model);
    }

    public function deleteAction($id)
    {

    }

    public function getModelsByBrandsIDAction($brandsId){
        if(is_null($brandsId))
            $brandsId = HdBrands::findFirst()->id;
        $autoModels = $this->getModelsByBrandsID($brandsId);
        $array = array();
        foreach($autoModels as $models ){
            $array[$models->id] = $models->name;
        }
        echo json_encode($array);exit;
    }

    protected function _getModel($id)
    {
        $id = $this->filter->sanitize($id, \Phalcon\Filter::FILTER_INT_CAST);
        $model = HdAutoModels::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Mvc\Model\Exception("对象不存在");
        }
        return $model;
    }

    protected function _getBrands()
    {
        $brandsComponent = new BrandsComponent();

        return $brands = $brandsComponent->getAutoBrands();

    }

    protected function getModelsByBrandsID($brandsId){
        return $autoModels = HdAutoModels::find(array('conditions'=>'brands_id=:brandsId:','bind'=>array('brandsId'=>$brandsId)));
        //todo 将brands_id 修改为 brands_id
    }


}

