<?php

class OrderController extends ControllerBase
{

    public function indexAction()
    {
        var_dump( $_POST );
        $models_id = $this->request->getPost( 'models_id' );
        $data = HdUserAuto::findFirst(
            array(
                'conditions' => 'models=:models:',
                'bind'       => array( 'models' => $models_id )
            ) );
        var_dump($data);
    }

    public function myorderAction()
    {

    }


}

