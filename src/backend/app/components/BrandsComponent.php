<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/26/15
 * Time: 15:43
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/26/15  Time: 15:43
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class BrandsComponent extends \Phalcon\Mvc\User\Component
{
    const CATEGORY_AUTO = 1;
    const CATEGORY_AUTO_PARTS = 2;

    public  $categoryArray = array(
        self::CATEGORY_AUTO => '汽车品牌',
        self::CATEGORY_AUTO_PARTS => '配件品牌',
    );

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function onConstruct()
    {

        // TODO: Implement __construct() method.
    }


    /**
     * 获取品牌的类型数据
     *
     * @param $brandsId
     * @return array
     */
    public function getBrandCategory($brandsId)
    {
        $modelCategory = array();
        $temp = HdAutoBrands::findFirst(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $brandsId)));
        if ($temp) {
            $modelCategory[] = self::CATEGORY_AUTO;
        }
        $temp = HdProductBrands::findFirst(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $brandsId)));
        if ($temp) {
            $modelCategory[] = self::CATEGORY_AUTO_PARTS;
        }
        unset($temp);
        return $modelCategory;
    }

    public function getIndustry($brandsId){
        $modelIndustry = array();
        $industryArray = array();
        $brandsIndustry = HdBrandsIndustry::find(array(
            'conditions'=>'brands_id=:brandsId:',
            'bind'=>array('brandsId'=>$brandsId)
        ));

        foreach ($brandsIndustry as $industry){
            $industryArray[] = $industry->industry_id;
        }
        $temp = HdIndustry::find(array('conditions'=>'id in (:ids:)',array('ids'=>'1,2')));

        return $temp;
    }

    public function getAutoBrands()
    {
        $autoBrandsArray = array();
        $autoBrands = HdAutoBrands::find();
        foreach($autoBrands as $brands){
            $autoBrandsArray[] = $brands->brands_id;
        }

        if($autoBrandsArray)
            return HdBrands::find(array('conditions'=>'id in ({id:array})','bind'=>array('id'=>$autoBrandsArray)));
        return array();
    }

//    public function


    /**
     * 更新商品信息的时候重置汽车品牌和汽配品牌关系
     *
     * @param array $inputBrandsCategory
     * @param $model HdBrands
     */
    public function resetBrandsCategory($inputBrandsCategory = array(), $model)
    {

        $rows = HdAutoBrands::find(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $model->id)));
        foreach ($rows as $row) {
            $row->delete();
            unset($row);
        }

        $rows = HdProductBrands::find(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $model->id)));
        foreach ($rows as $row) {
            $row->delete();
            unset($row);
        }

        foreach ($inputBrandsCategory as $brandsCategory) {
            switch ($brandsCategory) {
                case BrandsComponent::CATEGORY_AUTO:
                    $temp = new HdAutoBrands();
                    $temp->brands_id = $model->id;
                    $temp->save();
                    unset($temp);
                    break;
                case BrandsComponent::CATEGORY_AUTO_PARTS:
                    $temp = new HdProductBrands();
                    $temp->brands_id = $model->id;
                    $temp->save();
                    unset($temp);
                    break;
            }
        }
    }

    /**
     * 更新商品信息的时候重置汽车品牌和汽配品牌关系
     *
     * @param array $inputIndustry
     * @param $model HdBrands
     */
    public function resetBrandsIndustry($inputIndustry = array(), $model)
    {

        $rows = HdBrandsIndustry::find(array(
            'conditions' => 'brands_id=:brandsId: ',
            'bind' => array('brandsId' => $model->id)));
        foreach ($rows as $row) {
            $row->delete();
            unset($row);
        }
        foreach ($inputIndustry as $v) {
            $temp = new HdBrandsIndustry();
            $temp->brands_id = $model->id;
            $temp->industry_id = $v;
            $temp->save();
            unset($temp);

        }
    }


}