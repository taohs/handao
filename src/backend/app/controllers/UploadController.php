<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 9/13/15
 * Time: 18:09
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 9/13/15  Time: 18:09
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class UploadController extends ControllerBase
{

    public static $brands = null;
    public static $models = null;
    public static $modelsExact = null;

    public static $dataMsg = array('品牌', '车系', '排量与年份', '机滤', '空调滤', '空气滤', '机油');
    public static $productCategory = array();


    function indexAction()
    {
        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();
//                var_dump($files);
                foreach ($files as $f) {
                    echo $f->getName();
                    $logoname = APP_PUBLIC . '/uploads/files/' . md5($f->getName()) . '.' . $f->getExtension();
                    $f->moveTo($logoname);
                    $stream = fopen($logoname, 'r');
//                   $content = fread($stream,1000);
                    echo '<br/>';
                    echo '<br/>';
                    echo '<br/>';
                    $i = 0;
                    while ($data = fgetcsv($stream)) {
//                        var_dump($data);
                        $i++;
                        if ($i == 1) {

                            continue;
                        } else {
                            foreach ($data as $key => $val) {
                                echo $val;
                                switch ($key) {
                                    case 0:
                                        $this->dealBrands($val);
                                        break;
                                    case 1:
                                        $this->dealModels($val);
                                        break;
                                    case 2:
                                        $this->dealModelsExact($val);
                                        break;
                                    case 3:
                                        $this->dealProducts($val, $key);
                                        break;
                                    case 4:
                                        $this->dealProducts($val, $key);
                                        break;
                                    case 5:
                                        $this->dealProducts($val, $key);
                                        break;
                                    case 6:
                                        $this->dealProducts($val, $key);
                                        break;
                                }
                                echo 1;
//                            var_dump(empty($val));
//                              echo (iconv("UTF-8", "GB2312//IGNORE", $da));
                            }
                        }

                        echo '<br>';
                    }
//                   echo iconv("UTF-8", "GB2312//IGNORE", $content) ;
                }
            }
//            echo 1;
            $this->view->disable();
        }
    }

    function dealBrands($brands = null)
    {
        if (is_null($brands) or empty($brands)) {
            return self::$brands;
        } else {
            //查询 没有就新增
            $brandsModel = HdBrands::findFirst(array('conditions' => 'name=:name:', 'bind' => array('name' => $brands)));
            if (!$brandsModel) {
                $brandsModel = new HdBrands();
                $brandsModel->name = trim($brands);
                $brandsModel->initials = substr(strtoupper(CUtf8::encode($brands)), 0, 1);
                $brandsModel->name_en = '';
                $brandsModel->country = '';
                $brandsModel->create_time = date('Y-m-d H:i:s');
                $brandsModel->save();
            }
            $autoBrands = HdAutoBrands::findFirst(array(
                'conditions' => 'brands_id=:brandsId:',
                'bind' => array('brandsId' => $brandsModel->id)
            ));
            if (!$autoBrands) {
                $autoBrands = new HdAutoBrands();
                $autoBrands->brands_id = $brandsModel->id;
                $autoBrands->create_time = date('Y-m-d H:i:s');
                $autoBrands->save();
            }


            self::$brands = $brandsModel;
            return self::$brands;
        }
    }

    function getBrands()
    {
        return self::$brands;
    }

    function dealModels($models = null)
    {
        if (is_null($models) or empty($models)) {
            return self::$models;
        } else {
            //查询 没有就新增
            $modelsModel = HdAutoModels::findFirst(array('conditions' => 'name=:name:', 'bind' => array('name' => $models)));
            if (!$modelsModel) {
                $brands = self::$brands;
                $modelsModel = new HdAutoModels();
                $modelsModel->name = trim($models);
                $modelsModel->brands_id = $brands->id;
                $modelsModel->years = '';
                $modelsModel->create_time = date('Y-m-d H:i:s');
                $modelsModel->save();
            }
            self::$models = $modelsModel;
            return self::$models;
        }
    }

    function dealModelsExact($modelsExact = null)
    {
        if (is_null($modelsExact) or empty($modelsExact)) {
            return self::$modelsExact;
        } else {
            //查询 没有就新增
            $modelsExactModel = HdAutoModelsExact::findFirst(array('conditions' => 'name=:name:', 'bind' => array('name' => $modelsExact)));

            if (!$modelsExactModel) {
                $brands = self::$brands;
                $models = self::$models;
                echo 1;
                $modelsExactModel = new HdAutoModelsExact();
                $modelsExactModel->name = trim($modelsExact);
                $modelsExactModel->brands_id = $brands->id;
                $modelsExactModel->models_id = $models->id;
                $modelsExactModel->years = '1003';
                $modelsExactModel->description = '123';
                $modelsExactModel->create_time = date('Y-m-d H:i:s');
                $modelsExactModel->update_time = date('Y-m-d H:i:s');
                $modelsExactModel->save();
            }
            self::$modelsExact = $modelsExactModel;
            return self::$modelsExact;
        }
    }

    /**
     * 新增商品或者什么都不做
     * @param $productsName
     * @param $loopKey
     */
    function dealProducts($products, $loopKey)
    {
        if (!empty($products)) {
            $productsNameArray = explode('￥', $products);
            $productsName = trim($productsNameArray[0]);
            $productsPrice = trim($productsNameArray[1]);

            $productsModel = HdProduct::findFirst(array(
                'conditions' => 'name=:name: and member_price=:price:',
                'bind' => array('name' => $productsName, 'price' => $productsPrice)
            ));
            if (!$productsModel) {
                $productsModel = new HdProduct();
                $productsModel->name = $productsName;
                $productsModel->category = $this->getProductCategory($loopKey);
                $productsModel->market_price = $productsPrice;
                $productsModel->member_price = $productsPrice;
                $productsModel->activity_price = $productsPrice;
                $productsModel->active = 1;
                $productsModel->create_time = date('Y-m-d H:i:s');
                $productsModel->save();
            }

            $this->dealProductsRecommend($productsModel);
        }

    }

    /**
     * 新增商品推荐
     * 将配件和车型匹配
     */
    function dealProductsRecommend($productModel)
    {
        $modelsExactModel = self::$modelsExact;

        $model = HdAutoProductRecommend::findFirst(array(
            'conditions' => 'exact_id=:exact_id: and product_id=:pid:',
            'bind' => array('exact_id' => $modelsExactModel->id, 'pid' => $productModel->id)
        ));
        if (!$model) {
            $model = new HdAutoProductRecommend();
            $model->exact_id = $modelsExactModel->id;
            $model->product_id = $productModel->id;
        }
        return $model->save();
    }

    function getProductCategory($key)
    {
        $category = self::$productCategory;
        if (isset($category[$key])) {
            return $category[$key];
        } else {
            $dataMsg = self::$dataMsg;
            $name = $dataMsg[$key];

            $model = HdProductCategory::findFirst(array(
                'conditions' => 'name=:name:',
                'bind' => array('name' => $name)
            ));
            if (!$model) {
                $model = new HdProductCategory();
                $model->name = $name;
                $model->parent_id = 1;
                $model->active = 1;
                $model->save();
            }
            $category[$key] = $model->id;
            self::$productCategory = $category;
            return $category[$key];
        }
    }
}