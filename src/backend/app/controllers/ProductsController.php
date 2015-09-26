<?php

class ProductsController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName() . '/list');
    }

    public function listAction()
    {
        $paginate = new Phalcon\Paginator\Adapter\Model(array(
            'data' => HdProduct::find(),
            'page' => $this->request->getQuery('page', \Phalcon\Filter::FILTER_INT),
            'limit' => $this->config->paginate->limit
        ));
        $this->view->setVar('paginate', $paginate->getPaginate());
    }

    public function createAction()
    {
        $model = new HdProduct();
        $category = HdProductCategory::find();

        if ($this->request->isPost()) {

            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputCategory = $this->request->getPost('inputCategory', \Phalcon\Filter::FILTER_INT);
            $inputMarketPrice = $this->request->getPost('inputMarketPrice', \Phalcon\Filter::FILTER_FLOAT);
            $inputMemberPrice = $this->request->getPost('inputMemberPrice', \Phalcon\Filter::FILTER_FLOAT);
            $inputDescription = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);
            $inputAttributes = $this->request->getPost('inputAttributes', \Phalcon\Filter::FILTER_STRING);




            if (empty($inputName) or empty($inputCategory) or empty($inputMarketPrice) or empty($inputMemberPrice)) {
                $this->flash->error('信息填写不完整,请确认输入商品名称，所属类型，市场价格和会员价格');
                return $this->refresh();
            }

            $model->name = $inputName;
            $model->category = $inputCategory;
            $model->market_price = $inputMarketPrice;
            $model->member_price = $inputMemberPrice;
            $model->description = $inputDescription;
//            $matches = preg_split(PHP_EOL,$inputAttributes);
            $inputAttributesArray = explode(PHP_EOL, $inputAttributes);
            $temp = array();

            foreach ($inputAttributesArray as $attribute) {
                $length = strpos($attribute, '：');
                if ($length) {
                    $key = mb_strcut($attribute, 0, $length, 'utf8');
                    $value = mb_strcut($attribute, $length + strlen('：'), mb_strlen($attribute, 'utf8'), 'utf8');

                } else {
                    $length = strpos($attribute, ':');
                    if ($length == false) {
                        break;
                    } else {
                        $key = mb_strcut($attribute, 0, $length, 'utf8');
                        $value = mb_strcut($attribute, $length + strlen(':'), mb_strlen($attribute), 'utf8');
                    }
                }
                $temp[$key] = $value;
            }

            $model->attributes = json_encode($temp);

            if ($model->save()) {
                $this->flash->success('保存成功');
            } else {
                $this->flash->error('保存失败');
            }
            $this->refresh();
        }


        $this->view->setVar('model', $model);
        $this->view->setVar('category', $category);

    }

    public function updateAction($id)
    {
        $model = $this->_getModel($id);
        $category = HdProductCategory::find();

        if($this->request->isPost()){
            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT);
            $inputName = $this->request->getPost('inputName', \Phalcon\Filter::FILTER_STRING);
            $inputCategory = $this->request->getPost('inputCategory', \Phalcon\Filter::FILTER_INT);
            $inputMarketPrice = $this->request->getPost('inputMarketPrice', \Phalcon\Filter::FILTER_FLOAT);
            $inputMemberPrice = $this->request->getPost('inputMemberPrice', \Phalcon\Filter::FILTER_FLOAT);
            $inputDescription = $this->request->getPost('inputDescription', \Phalcon\Filter::FILTER_STRING);
            $inputAttributes = $this->request->getPost('inputAttributes', \Phalcon\Filter::FILTER_STRING);


            if($model->id != $inputId){
                $this->flash->error('信息不符合');
                return $this->refresh();
            }


            if (empty($inputName) or empty($inputCategory) or empty($inputMarketPrice) or empty($inputMemberPrice)) {
                $this->flash->error('信息填写不完整,请确认输入商品名称，所属类型，市场价格和会员价格');
                return $this->refresh();
            }


            $model->name = $inputName;
            $model->category = $inputCategory;
            $model->market_price = $inputMarketPrice;
            $model->member_price = $inputMemberPrice;
            $model->description = $inputDescription;
            $model->attributes = $this->stringToJson($inputAttributes);

            if($model->save()){
                $this->flash->success('保存成功');
            }else{
                $this->flash->error('保存失败');
            }
            return  $this->refresh();

        }


        $tempAttributesArray = json_decode($model->attributes);
        $tempAttributesString = '';
        foreach($tempAttributesArray as $k=>$v ){
            $tempAttributesString .= $k.'：'.$v.PHP_EOL;
        }
        $model->attributes = trim($tempAttributesString);
        $this->view->setVar('model', $model);
        $this->view->setVar('category', $category);
    }

    public function deleteAction($id)
    {
        $model = $this->_getModel($id);

    }

    protected function _getModel($id)
    {
        $model = HdProduct::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Exception("id 错误");
        }
        return $model;
    }

    protected function stringToJson($string){
        $inputAttributesArray = explode(PHP_EOL, $string);
        $temp = array();

        foreach ($inputAttributesArray as $attribute) {
            $length = strpos($attribute, '：');
            if ($length) {
                $key = mb_strcut($attribute, 0, $length, 'utf8');
                $value = mb_strcut($attribute, $length + strlen('：'), mb_strlen($attribute, 'utf8'), 'utf8');

            } else {
                $length = strpos($attribute, ':');
                if ($length == false) {
                    break;
                } else {
                    $key = mb_strcut($attribute, 0, $length, 'utf8');
                    $value = mb_strcut($attribute, $length + strlen(':'), mb_strlen($attribute), 'utf8');
                }
            }
            $temp[$key] = $value;
        }

        return json_encode($temp);
    }

    protected function jsonToString($json){
        $tempAttributesArray = json_decode($json);
        $tempAttributesString = '';
        foreach($tempAttributesArray as $k=>$v ){
            $tempAttributesString .= $k.'：'.$v.PHP_EOL;
        }
        return trim($tempAttributesString);
    }

    function getModelsExactRecommendAction($modelsExactId){
        $productsRecommend = HdAutoProductRecommend::find(array(
            'conditions'=>'exact_id=:exact_id:',
            'bind'=>array('exact_id'=>$modelsExactId),
        ))->toArray();

        $productsIds = array();
        $productsRecommendFeatured  = array();
        $productsGroupByCategory = array();
        $productsCategory = array();

        foreach($productsRecommend as $row){
            $productsIds[] = $row['product_id'];
            if($row['featured']==1){
                $productsRecommendFeatured[] = $row['product_id'];
            }
        }

        $products = HdProduct::find(array(
            'conditions'=>'id in ({ids:array})',
            'bind'=>array('ids'=>$productsIds),
            'order'=>'category',
        ))->toarray();

        foreach($products as $row){
            /**
             * @var $row HdProduct => array
             */
            if(in_array($row['id'],$productsRecommendFeatured)){
                $row['featured'] = 1;
            }else{
                $row['featured'] = 0;
            }

            $productsGroupByCategory[$row['category']][] = $row;
            if(!in_array($row['category'],$productsCategory)){
                $productsCategory[]=$row['category'];
            }
        }

        $productsCategoryData =HdProductCategory::find(array(
            'conditions'=>'id in ({ids:array})',
            'bind'=>array('ids'=>$productsCategory)
        ))->toArray();

        $finishData = array();
        foreach($productsCategoryData as $key=>$row){
            $row['data'] = $productsGroupByCategory[$row['id']];
            $finishData[]=$row;
        }
        echo json_encode($finishData);exit;
        var_export($finishData);exit;




        var_dump($productsCategory);
        var_dump($productsCategoryData);
        var_dump($productsIds);
        var_dump($products);
        var_dump($productsGroupByCategory);
    }

}

