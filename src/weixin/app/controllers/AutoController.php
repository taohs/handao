<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 15/10/9
 * Time: 23:08
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 15/10/9  Time: 23:08
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class AutoController extends ControllerBase
{

    public function brandsOptionAction($brandsId){
        if (is_null($brandsId))
            $brandsId = HdBrands::findFirst()->id;
        $autoModels = $this->getModelsByBrandsID($brandsId);
        $array = $modelExactArray = array();
        $i = 0;
        foreach ($autoModels as $models) {
            if ($i == 0) {
                $modelExact = $this->getModelExactByModelsId($models->id);
                foreach ($modelExact as $exact) {
                    $modelExactArray[$exact->id] = $exact->name;
                }
            }
            $array[$models->id] = $models->name;
            $i++;
        }
        echo json_encode(array('models' => $array, 'modelExact' => $modelExactArray));
        exit;
    }

    public function modelsOptionAction($modelsId){
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

    protected function getModelsByBrandsID($brandsId)
    {
        return $autoModels = HdAutoModels::find(array('conditions' => 'brands_id=:brandsId:', 'bind' => array('brandsId' => $brandsId)));
        //todo 将brands_id 修改为 brands_id
    }
    public function getModelExactByModelsID($modelsId)
    {
        return $autoModels = HdAutoModelsExact::find(array('conditions' => 'models_id=:modelsId:', 'bind' => array('modelsId' => $modelsId)));
    }
}