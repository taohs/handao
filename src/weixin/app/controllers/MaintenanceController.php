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
        $products = HdBrands::find();
        var_dump($products);exit;
    }

    /**
     * 服务选择
     */
    public function serveselectAction(){

    }

}

