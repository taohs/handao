<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $a_z=range('A','Z');
        $brands = HdBrands::find( array( 'order' => 'initials asc' ) );
        $this->view->setvar( 'brands', $brands );
        $this->view->setVar('a_z',$a_z);
    }

}

