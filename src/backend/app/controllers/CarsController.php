<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/17/15
 * Time: 01:19
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/17/15  Time: 01:19
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class CarsController extends ControllerBase
{

    function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    function listAction()
    {
        $model = HdAutoModelsExact::find(array('order' => 'brands_id asc,models_id asc'));
        $page = $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT);
        $paginateModel = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $model,
            'limit' => $this->config->paginate->limit,
            'page' => $page,
        ));
        $this->view->setVar('model', $model);
        $this->view->setVar('paginate', $paginateModel->getPaginate());
    }

    /**
     * 关联汽车系列
     * 关联汽车品牌
     */
    function createAction()
    {
        $brandsComponent = new BrandsComponent();

        $brands = $brandsComponent->getAutoBrands();

        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $brands[0]->id)
        ));


        //产品类型
        $productCategoryModels = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id != 0',
            'bind' => array('active' => 1)
        ));

//        foreach($productCategoryModels as $model){
//            echo $model->name;
//        }


        if ($this->request->isPost()) {
            $inputBrands = $this->request->getPost('inputBrands', \Phalcon\Filter::FILTER_INT);
            $inputAutoModels = $this->request->getPost('inputAutoModels', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputYears = $this->request->getPost('inputYears', \Phalcon\Filter::FILTER_STRING);
            $inputProducts = $this->request->getPost('inputProducts', \Phalcon\Filter::FILTER_STRING);

            if (empty($inputName) or empty($inputAutoModels) or empty($inputBrands)) {
                $this->flash->error("输入信息问完整，请输入完整的品牌，系列和名称");
                return $this->refresh();
            }

            $model = new HdAutoModelsExact();
            $model->name = $inputName;
            $model->brands_id = $inputBrands;
            $model->models_id = $inputAutoModels;
            $model->year = $inputYears;
            $model->create_time = date('Y-m-d H:i:s');
            $model->update_time = date('Y-m-d H:i:s');


            if ($model->save()) {
                $this->flash->success("保存成功");
                if (!empty($inputProducts)) {
                    foreach ($inputProducts as $row) {
                        $tempProductRecommend = new HdAutoProductRecommend();
                        $tempProductRecommend->exact_id = $model->id;
                        $tempProductRecommend->product_id = $row;
                        $tempProductRecommend->save();
                        unset($tempProductRecommend);
                    }
                }

            } else {
                $this->flash->error("保存失败");
            }
            return $this->refresh();


        }


        $this->view->setVar('brands', $brands);
        $this->view->setVar('productCategoryModels', $productCategoryModels);
        $this->view->setVar('autoModels', $autoModels);
    }

    function updateAction($id)
    {
        $model = $this->_getModel($id);
        $brandsComponent = new BrandsComponent();

        $brands = $brandsComponent->getAutoBrands();

        $autoModels = HdAutoModels::find(array(
            'conditions' => 'brands_id=:brandsId:',
            'bind' => array('brandsId' => $model->brands_id)
        ));

        $productsRecommend = HdAutoProductRecommend::find(array(
//            'columns' => 'id,product_id',
            'conditions' => 'exact_id=:exact_id:',
            'bind' => array('exact_id' => $model->id)
        ));


        $useProductRecommend = array();
        foreach ($productsRecommend as $row) {
            $useProductRecommend[] = $row->product_id;
        }


        if ($this->request->isPost()) {
            $inputBrands = $this->request->getPost('inputBrands', \Phalcon\Filter::FILTER_INT);
            $inputAutoModels = $this->request->getPost('inputAutoModels', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputYears = $this->request->getPost('inputYears', \Phalcon\Filter::FILTER_STRING);
            $inputProducts = $this->request->getPost('inputProducts', \Phalcon\Filter::FILTER_STRING);

            if (empty($inputName) or empty($inputAutoModels) or empty($inputBrands)) {
                $this->flash->error("输入信息问完整，请输入完整的品牌，系列和名称");
                return $this->refresh();
            }


            $model->name = $inputName;
            $model->brands_id = $inputBrands;
            $model->models_id = $inputAutoModels;
            $model->year = $inputYears;

            $model->update_time = date('Y-m-d H:i:s');
            if ($model->save()) {
                $this->flash->success("保存成功");


                foreach ($productsRecommend as $row) {
                    $row->delete();
                }

                if (!empty($inputProducts)) {
                    foreach ($inputProducts as $row) {
                        $tempProductRecommend = new HdAutoProductRecommend();
                        $tempProductRecommend->exact_id = $model->id;
                        $tempProductRecommend->product_id = $row;
                        $tempProductRecommend->save();
                        unset($tempProductRecommend);
                    }
                }

            } else {
                $this->flash->error("保存失败");
            }
            return $this->refresh();


        }

        //产品类型
        $productCategoryModels = HdProductCategory::find(array(
            'conditions' => 'active=:active: and parent_id != 0',
            'bind' => array('active' => 1)
        ));


//        var_dump($useProductRecommend);
//        exit;


        $this->view->setVar('model', $model);
        $this->view->setVar('productCategoryModels', $productCategoryModels);
        $this->view->setVar('productsRecommand', $productsRecommend);
        $this->view->setVar('useProductRecommend', $useProductRecommend);
        $this->view->setVar('brands', $brands);
        $this->view->setVar('autoModels', $autoModels);
    }

    function deleteAction()
    {
    }

    protected function _getModel($id)
    {
        $model = HdAutoModelsExact::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Exception("信息不匹配");
        }
        return $model;
    }

    public function getModelExactByModelsIDAction($modelsId)
    {

        if (is_null($modelsId))
            $modelsId = HdAutoModels::findFirst()->id;
        $autoModels = $this->getModelExactByModelsID($modelsId);
        $array = array();
        foreach ($autoModels as $models) {
            $array[$models->id] = $models->name;
        }
        echo json_encode($array);
        exit;
    }

    public function getModelExactByModelsID($modelsId)
    {
        return $autoModels = HdAutoModelsExact::find(array('conditions' => 'models_id=:modelsId:', 'bind' => array('modelsId' => $modelsId)));
    }
}