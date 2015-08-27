<?php

class MaintenanceController extends ControllerBase
{

    public $fees=150;//服务费
    public function initialize()
    {


        $this->view->setMainView( 'selectauto' );

    }
    public function indexAction()
    {

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

        $this->view->setvar( 'brands', $brands );
        $this->view->setvar( 'a_z', $a_z );
        $this->view->setvar( 'autoModelExact', $autoModelExact );
        $this->view->setvar( 'autoModel', $autoModel );

    }

    /**
     * 服务选择
     */
    public function serveselectAction()
    {
        $brands_id = $this->request->getQuery( 'brands_id' );
        $models_id = $this->request->getQuery( 'models_id' );
        $brands = HdBrands::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $brands_id )
        ) );
        $models = HdAutoModels::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $models_id )
        ) );
        $category = HdProductCategory::find();
        $product = HdProduct::find();

        $this->view->setVar( 'brands', $brands );
        $this->view->setVar( 'models', $models );
        $this->view->setVar( 'category', $category );
        $this->view->setVar( 'product', $product );
        $this->view->setVar( 'fees', $this->fees );
    }

}

