<?php

class HdBrands extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $name_en;

    /**
     *
     * @var string
     */
    public $initials;

    /**
     *
     * @var string
     */
    public $logo_path;

    /**
     *
     * @var string
     */
    public $logo_small_path;

    /**
     *
     * @var string
     */
    public $logo_big_path;

    /**
     *
     * @var string
     */
    public $country;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'HdAutoModels', 'brands_id', array('alias' => 'HdAutoModels'));
        $this->hasMany('id', 'HdAutoModelsExact', 'brands_id', array('alias' => 'HdAutoModelsExact'));
        $this->hasMany('id', 'HdBrandsIndustry', 'brands_id', array('alias' => 'HdBrandsIndustry'));
        $this->hasMany('id', 'HdProductBrands', 'brands_id', array('alias' => 'HdProductBrands'));
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrands[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdBrands
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_brands';
    }

    public function getIndustry(){
        $modelIndustry = array();
        $industryArray = array();
        $brandsIndustry = HdBrandsIndustry::find(array(
            'conditions'=>'brands_id=:brandsId:',
            'bind'=>array('brandsId'=>$this->id)
        ));

        foreach ($brandsIndustry as $industry){
            $industryArray[] = $industry->industry_id;
        }
        $temp = HdIndustry::find(array('conditions'=>'id in (:ids:)',array('ids'=>'1,2')));

        return $temp;
    }

    /**
     * 获取品牌的类型数据
     *
     * @param $brandsId
     * @return array
     */
    public function getBrandCategory()
    {
        $modelCategory = array();
        $temp = HdAutoBrands::findFirst(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $this->id)));
        if ($temp) {
            $modelCategory[] = BrandsComponent::CATEGORY_AUTO;
        }
        $temp = HdProductBrands::findFirst(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $this->id)));
        if ($temp) {
            $modelCategory[] = BrandsComponent::CATEGORY_AUTO_PARTS;
        }
        unset($temp);

        return $modelCategory;
    }

    public function getBrandCategoryName(){
        $modelCategory = array();
        $tempArray  = $this->getBrandCategory();
        foreach ($tempArray as $temp){
            $modelCategory[$temp] = BrandsComponent::$categoryArray[$temp];
        }
        return $modelCategory;
    }

}
