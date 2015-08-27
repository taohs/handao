<?php

class MaintenanceController extends ControllerBase
{

    public function indexAction()
    {

    }

    /**
     * 汽车选择
     */
    public function autoselectAction()
    {
        $this->view->setMainView('selectauto');
        $brands = HdBrands::find(array('order'=>'initials asc'));
        $a_z=range('A','Z');

        $autoModel=HdAutoModels::find();
        $autoModelExact=HdAutoModelsExact::find();

        $this->view->setvar('brands',$brands);
        $this->view->setvar('a_z',$a_z);
        $this->view->setvar('autoModelExact',$autoModelExact);
        $this->view->setvar('autoModel',$autoModel);

    }

    /**
     * 服务选择
     */
    public function serveselectAction(){

    }

}

