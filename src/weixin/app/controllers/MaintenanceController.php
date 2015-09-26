<?php

class MaintenanceController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setMainView( 'selectauto' );

    }

    public function indexAction()
    {
        return $this->response->redirect( 'maintenance/autoselect' );
    }

    /**
     * 汽车选择
     */
    public function autoselectAction()
    {

        $brands = HdBrands::find( array( 'order' => 'initials asc' ) );
        $a_z = range( 'A', 'Z' );

        $autoModel = HdAutoModels::find();
        $autoModelExact = HdAutoModelsExact::find();
        $autoModelArray = array();
        foreach($autoModel as $row){
            /**
             * @var $row HdAutoModels
             */
            $autoModelArray[$row->brands_id][] = $row;
        }
        $autoModelExactArray = array();
        foreach($autoModelExact as $row){
            /**
             * @var $row HdAutoModelsExact
             */
            $autoModelExactArray[$row->models_id][] = $row;
        }

//        $autoModel->filter(function($autoModel){
//            if($autoModel->id>1){
//                return $autoModel;
//            }
//        });

        $this->view->setvar( 'brands', $brands );
        $this->view->setvar( 'a_z', $a_z );
        $this->view->setvar( 'autoModelExact', $autoModelExact );
        $this->view->setvar( 'autoModelExactArray', $autoModelExactArray );
        $this->view->setvar( 'autoModel', $autoModel );
        $this->view->setvar( 'autoModelArray', $autoModelArray );
//        var_dump($autoModelArray);
//        exit;

    }

    /**
     * 服务选择
     */
    public function serveselectAction()
    {
        $brands_id = $this->request->getQuery( 'brands_id' );
        $models_id = $this->request->getQuery( 'models_id' );

        $exact_id = $this->request->getQuery( 'exact_id' );
        $models = HdAutoModels::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $models_id )
        ) );
        if (! $models) {
            return $this->response->redirect( 'maintenance/autoselect' );
        }

        $brands = HdBrands::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $brands_id )
        ) );
        $modelsExact = HdAutoModelsExact::findFirst(array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $exact_id )
        ));
        if (! $modelsExact || $modelsExact->models_id!=$models->id ) {
            return $this->response->redirect( 'appointment/index' );
        }


        $recommend = HdAutoProductRecommend::find( array( 'conditions' => 'exact_id = :exact_id:', 'bind' => array( 'exact_id' => $exact_id ) ) );
        $recommendFeatured = array();
        $product_id_str = "";
        $i = 0;
        foreach ($recommend as $row) {
            $i==0?$dian = '':$dian = ',';
            $product_id_str .= $dian . $row->product_id;
            $i++;

            if($row->featured==1){
                $recommendFeatured[] = $row->product_id;
            }

        }
        $product = HdProduct::find( array( 'conditions' => "id in ($product_id_str)" ) );

        $productGroup = array();

        foreach ($product as $row) {
            $category_id_array[]=  $row->category;
            $rowArray = $row->toArray();
            if(in_array($row->id,$recommendFeatured)){
                $rowArray['featured']=1;
            }else{
                $rowArray['featured']=0;
            }
            $productGroup[$row->category][] = $rowArray;
        }


        $category_id_str="";
        $category_id_array= array_unique($category_id_array);
        $i = 0;
        foreach ($category_id_array as $row){
            $i==0?$dian = '':$dian = ',';
            $category_id_str.=$dian.$row;
            $i++;
        }
        $brands = HdBrands::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $brands_id )
        ) );
        $category = HdProductCategory::find(array( 'conditions' => "id in ($category_id_str)" ) );

        $this->view->setVar( 'brands', $brands );
        $this->view->setVar( 'models', $models );
        $this->view->setVar( 'modelsExact', $modelsExact );
        $this->view->setVar( 'category', $category );
        $this->view->setVar( 'product', $product );
        $this->view->setVar( 'productGroup', $productGroup );
        $this->view->setVar( 'fees', $this->fees );
    }

}

