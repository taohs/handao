<?php

class BrandsController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');

    }

    /**
     * 品牌列表
     *
     */
    public function listAction()
    {
        $page = $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT_CAST);
        $model = HdBrands::find(array('order'=>'initials asc'));
        $paginateModel = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $model,
            'limit' => $this->config->paginate->limit,
            'page' => $page,

        ));
        $this->view->setVar('paginate', $paginateModel->getPaginate());
    }

    public function itemAction($id)
    {
        $model = $this->_getModel($id);
        $this->view->setVar('model', $model);
    }

    public function createAction()
    {
        $letter = new Letter();
        $initials = $letter->getInitialsArray();
        $industries = HdIndustry::find();

        if ($this->request->isPost()) {

            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputInitials = $this->request->getPost('inputInitials', \Phalcon\Filter::FILTER_ALPHANUM);
            $inputCountry = $this->request->getPost('inputCountry', \Phalcon\Filter::FILTER_STRING);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_STRING);
            $inputBrandsCategory = $this->request->getPost('inputBrandsCategory', \Phalcon\Filter::FILTER_STRING);


            if (empty($inputName) or empty($inputInitials)) {
                $this->flash->error("名称或首字母不能为空");
                return $this->refresh();
            }

            $logoUrl = $this->_uploadAndGetLogo();

            $model = new HdBrands();
            $model->name = $inputName;
            $model->initials = $inputInitials;
            $model->country = $inputCountry;
            $model->logo_path = $logoUrl;

            if ($model->save()) {
                $brandsComponent = new BrandsComponent();
                $brandsComponent->resetBrandsIndustry($inputIndustry,$model);
                $brandsComponent->resetBrandsCategory($inputBrandsCategory, $model);

                $this->flash->success("保存成功");
            } else {
                $this->flash->error("保存失败");
            }

            return $this->refresh();
        }
        $model = new HdBrands();
        $this->view->setVar('model', $model);
        $this->view->setVar('initials', $initials);
        $this->view->setVar('industries', $industries);
        $this->view->setVar('brandsComponent', new BrandsComponent());
        $this->view->setVar('brandsAuto', BrandsComponent::CATEGORY_AUTO);
        $this->view->setVar('brandsAutoParts', BrandsComponent::CATEGORY_AUTO_PARTS);
    }

    public function updateAction($id)
    {
        $model = $this->_getModel($id);
        $letter = new Letter();
        $initials = $letter->getInitialsArray();
        $industries = HdIndustry::find();
        $industryArray = array();
        $modelIndustries = $model->getHdBrandsIndustry();

        if (!empty($modelIndustries)) {
            foreach ($modelIndustries as $in) {
                $industryArray[] = $in->industry_id;
            }
        }
        $brandsComponent = new BrandsComponent();

        $modelCategory = $model->getBrandCategory();


        if (!empty($modelIndustries)) {
            foreach ($modelIndustries as $in) {
                $industryArray[] = $in->industry_id;
            }
        }
//exit;
        if ($this->request->isPost()) {

            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputInitials = $this->request->getPost('inputInitials', \Phalcon\Filter::FILTER_ALPHANUM);
            $inputCountry = $this->request->getPost('inputCountry', \Phalcon\Filter::FILTER_STRING);
            $inputIndustry = $this->request->getPost('inputIndustry', \Phalcon\Filter::FILTER_STRING);
            $inputBrandsCategory = $this->request->getPost('inputBrandsCategory', \Phalcon\Filter::FILTER_STRING);


            if ($inputId != $model->id) {
                $this->flash->error("提交信息非法");
                return $this->refresh();
            }

            if (empty($inputName) or empty($inputInitials)) {
                $this->flash->error("名称或首字母不能为空");
                return $this->refresh();
            }

            $logoUrl = $this->_uploadAndGetLogo();

            $model->name = $inputName;
            $model->initials = $inputInitials;
            $model->country = $inputCountry;
            if (!is_null($logoUrl))
                $model->logo_path = $logoUrl;
            if ($model->save()) {

                $brandsComponent = new BrandsComponent();
                $brandsComponent->resetBrandsIndustry($inputIndustry,$model);
                $brandsComponent->resetBrandsCategory($inputBrandsCategory, $model);

                $this->flash->success("保存成功");
            } else {
                $this->flash->error("保存失败");
            }

            return $this->refresh();
        }

        $this->view->setVar('model', $model);
        $this->view->setVar('initials', $initials);
        $this->view->setVar('industries', $industries);
        $this->view->setVar('industryArray', $industryArray);
        $this->view->setVar('brandsComponent', $brandsComponent);
        $this->view->setVar('modelCategory', $modelCategory);

    }

    public function deleteAction($id)
    {
        if ($this->request->isPost()) {
            $model = $this->_getModel($id);
            return $this->refresh();
        }
    }

    public function autoAction()
    {

        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => HdBrandsIndustry::find(),
            'page' => $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT),
            'limit' => $this->config->paginate->limit
        ));

        $this->view->setVar('paginate', $paginate->getPaginate());

    }

    public function productAction()
    {

    }

    protected function _getModel($id)
    {
        $id = $this->filter->sanitize($id, \Phalcon\Filter::FILTER_INT_CAST);
        $model = HdBrands::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Mvc\Model\Exception("对象不存在");
        }
        return $model;
    }

    protected function _uploadAndGetLogo()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles()) {

            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file) {
                /**
                 * @var $file \Phalcon\Http\Request\File;
                 */
                if ($file->isUploadedFile()) {

                    if (!in_array($file->getExtension(), array('png', 'jpg'))) {
                        $this->flash->error("图片只能上传PNG，JPG格式");
                        return $this->refresh();
                    }

                    if ($file->getSize() > 1024 * 1024 * 2) {
                        $this->flash->error("图片只能上传2M以内大小");
                        return $this->refresh();
                    }
                    $logoUrl = LOGO_PATH . '/' . md5($file->getName() . time()) . '.' . $file->getExtension();
                    $logoPath = APP_PUBLIC . '/' . $logoUrl;
                    if (!@$file->moveTo($logoPath)) {
                        $this->flash->error("上传失败");
                        return $this->refresh();
                    }
                    return $logoUrl;
                }
            }
//            return $logoUrl;
        }

    }

}

