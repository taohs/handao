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
    public function getautoAction(){
        $bid=$this->request->getPost('cid');
        $type=$this->request->getPost('method');
        if($type==1){
            $auto = HdAutoModels::find(array(
                "conditions" => "brands_id = :brands_id:",
                "bind"       => array( 'brands_id' => $bid )
            ))->toArray();


        }else{
            $auto = HdAutoModelsExact::find(array(
                "conditions" => "models_id = :models_id:",
                "bind"       => array( 'models_id' => $bid )
            ))->toArray();
        }
        $data=$this->getJsonByArray($auto,$type);
        echo json_encode($data);
        exit;

    }
    public function getJsonByArray($auto,$type){
        $data['status']=1;
        $data['msg']='';
        $i=0;

        foreach($auto as $row){
            $data['msg'][$i]['id']=$row['id'];
            $data['msg'][$i]['title']=$row['name'];

            if($type==2){
                $data['msg'][$i]['url']="/appointment/service?brands_id={$row['brands_id']}&models_id={$row['models_id']}";

            }
            $i++;
        }
        return $data;
    }
    public function loginAction()
    {
        if ( $this->session->get( 'auth' )) {
            return $this->response->redirect( "index" );
        }
        $reUrl = $this->request->getQuery( 'reUrl' );
        if ($this->request->isPost()) {

            if ($this->security->checkToken( $this->session->get( '$PHALCON/CSRF/KEY$' ), $this->security->getSessionToken() )) {
                $mobile = $this->request->getPost( 'mobile' );
                $code = $this->request->getPost( 'code' );
                $user = HdUser::findFirst(
                    array(
                        'conditions' => 'mobile=:mobile:',
                        'bind'       => array(
                            'mobile' => $mobile,
                        )
                    ) );
                if ($this->userRegister( $user, $mobile )) {

                    if ($user && $this->security->checkHash( $code, $user->password )) {
                        $this->session->set( 'auth', $user );
                        return $this->response->redirect( $reUrl );
                    } else {
                        $this->flash->error( "验证码不正确" );
                    }
                }

            } else {

                $this->flash->error( "token errors" );
            }

        }
    }




    public function getcodeAction()
    {
        $code = mt_rand( 0, 9 ) . mt_rand( 0, 9 ) . mt_rand( 0, 9 ) . mt_rand( 0, 9 );
        /**
         * 短信发送到手机
         */
        $this->session->set( 'code', $code );

        echo $code;
        exit;

    }

    function userRegister( $user, $mobile )
    {
        $code = $this->session->get( 'code' );
        if ($user) {
            $user->password = $this->security->hash( $code );
            if ($user->save()) {
                return true;
            }

        } else {
            $HdUser = new HdUser();
            $HdUser->mobile = $mobile;
            $HdUser->username = $mobile;
            $HdUser->password = $this->security->hash( $code );
            $HdUser->update_time = date( "Y-m-d H:i:s" );
            $HdUser->create_time = date( "Y-m-d H:i:s" );
            if ($HdUser->save()) {
                return true;
            }
        }
        return false;
    }
}

