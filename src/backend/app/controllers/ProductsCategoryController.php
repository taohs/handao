<?php


class ProductsCategoryController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction()
    {

        $productsCategory = HdProductCategory::find(array('order' => 'parent_id'));

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $productsCategory,
            'limit' => $this->config->paginate->limit,
            'page' => $this->request->getQuery('page')
        ));


        $this->view->setVar('paginate', $paginate->getPaginate());
    }


    public function createAction()
    {
        if ($this->request->isPost()) {

            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputParent = $this->request->getPost('inputParent', \Phalcon\Filter::FILTER_INT);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_INT);

            if (empty($inputName)) {
                $this->flash->error("信息不完整");
                return $this->refresh();
            }


            $model = new HdProductCategory();
            $model->name = $inputName;
            $model->parent_id = $inputParent;
            $model->industry_id = $inputIndustry;
            $model->create_time = $this->now();
            $model->update_time = $this->now();
            if ($model->create()) {
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

            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputParent = $this->request->getPost('inputParent', \Phalcon\Filter::FILTER_INT);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_INT);

            if (empty($inputName) or $model->id != $inputId) {
                $this->flash->error("信息不完整");
                return $this->refresh();
            }

            $model->name = $inputName;
            $model->parent_id = $inputParent;
            $model->industry_id = $inputIndustry;
            $model->create_time = $this->now();
            $model->update_time = $this->now();
            if ($model->save()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            return $this->refresh();
        }
        $this->view->setVar('model', $model);
    }

    protected function _getModel($id)
    {
        $model = HdProductCategory::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Exception("信息错误");
        }
        return $model;
    }
}

