<?php


class ProductsCategoryController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction()
    {

        $productsCategory = HdProductCategory::find(array('order' => 'parent_id asc'));

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $productsCategory,
            'limit' => $this->config->paginate->limit,
            'page' => $this->request->getQuery('page')
        ));


        $this->view->setVar('paginate', $paginate->getPaginate());
    }


    public function createAction()
    {

        $category = HdProductCategory::find(array());
        $brandsComponent = new BrandsComponent();
        $industries = HdIndustry::find();


        if ($this->request->isPost()) {

            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputParent = $this->request->getPost('inputParent', \Phalcon\Filter::FILTER_INT);
            $inputDescription = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_INT);
            $inputActive = $this->request->getPost('inputActive', \Phalcon\Filter::FILTER_INT);


            if (empty($inputName)) {
                $this->flash->error("信息不完整");
                return $this->refresh();
            }


            $model = new HdProductCategory();
            $model->name = $inputName;
            $model->parent_id = $inputParent;
            $model->description = $inputDescription;
            $model->industry_id = $inputIndustry;
            $model->active = $inputActive;
//            $model->property   = 1;


            if ($model->create()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            return $this->refresh();
        }

        $this->view->setVar('category',$category);
        $this->view->setVar('brandsComponent', $brandsComponent);
        $this->view->setVar('industries', $industries);

    }

    public function updateAction($id)
    {
        $model = $this->_getModel($id);
        $category = HdProductCategory::find(array());
        $industries = HdIndustry::find();



        if ($this->request->isPost()) {

            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputParent = $this->request->getPost('inputParent', \Phalcon\Filter::FILTER_INT);
            $inputDescription = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_INT);
            $inputActive = $this->request->getPost('inputActive', \Phalcon\Filter::FILTER_INT);



            if (empty($inputName) or $model->id != $inputId) {
                $this->flash->error("信息不完整");
                return $this->refresh();
            }

            $model->name = $inputName;
            $model->parent_id = $inputParent;
            $model->industry_id = $inputIndustry;
            $model->description = $inputDescription;
            $model->active = $inputActive;


            if ($model->save()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            return $this->refresh();
        }
        $this->view->setVar('model', $model);
        $this->view->setVar('category',$category);
        $this->view->setVar('industries', $industries);


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

