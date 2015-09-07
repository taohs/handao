<?php

class MaintenanceController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setMainView( 'selectauto' );

    }
    public function indexAction()
    {
        return $this->response->redirect('maintenance/autoselect');
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


        $models = HdAutoModels::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $models_id )
        ) );
        if(!$models){
            return $this->response->redirect('maintenance/autoselect');
        }
        $brands = HdBrands::findFirst( array(
            "conditions" => "id = :id:",
            "bind"       => array( 'id' => $brands_id )
        ) );
        $category = HdProductCategory::find(array(
            "conditions" => "parent_id <>0"

        ));
        $product = HdProduct::find();

        $this->view->setVar( 'brands', $brands );
        $this->view->setVar( 'models', $models );
        $this->view->setVar( 'category', $category );
        $this->view->setVar( 'product', $product );
        $this->view->setVar( 'fees', $this->fees );
    }

}

