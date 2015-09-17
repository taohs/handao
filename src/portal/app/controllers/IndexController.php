<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $a_z = range('A', 'Z');
        $brands = HdBrands::find(array('order' => 'initials asc'));
        $brandsInitials= array();
        $brandsArray  = array();
        foreach($brands as $b){
            $brandsInitials[] = $b->initials;
            $brandsArray[$b->initials][]=$b;
        }

        $a_z = array_intersect($a_z,$brandsInitials);


        $this->view->setvar('brands', $brands);
        $this->view->setvar('brandsArray', $brandsArray);
        $this->view->setVar('a_z', $a_z);
    }

    public function getautoAction()
    {
        $bid = $this->request->getPost('cid');
        $type = $this->request->getPost('method');
        if ($type == 1) {
            $auto = HdAutoModels::find(array(
                "conditions" => "brands_id = :brands_id:",
                "bind" => array('brands_id' => $bid)
            ))->toArray();
        } else {
            $auto = HdAutoModelsExact::find(array(
                "conditions" => "models_id = :models_id:",
                "bind" => array('models_id' => $bid)
            ))->toArray();
        }
        $data = $this->getJsonByArray($auto, $type);
        echo json_encode($data);
        exit;
    }

    public function getJsonByArray($auto, $type)
    {
        $data['status'] = 1;
        $data['msg'] = '';
        $i = 0;
        foreach ($auto as $row) {

            $data['msg'][$i]['id'] = $row['id'];
            $data['msg'][$i]['title'] = $row['name'];
            if ($type == 2) {
                $data['msg'][$i]['url'] = "/appointment/service?brands_id={$row['brands_id']}&models_id={$row['models_id']}&exact_id={$row['id']}";
            }
            $i++;
        }
        return $data;
    }

    public function loginAction()
    {
        if ($this->session->get('auth')) {
            return $this->response->redirect("index");
        }
        $reUrl = $this->request->getQuery('reUrl');
        if ($this->request->isPost()) {
            if ($this->security->checkToken($this->session->get('$PHALCON/CSRF/KEY$'), $this->security->getSessionToken())) {
                $mobile = $this->request->getPost('mobile');
                $code = $this->request->getPost('code');
                $webApi = new WebapiComponent();
                $re = $webApi->webApiLogin($mobile, $code);
                if ($re->statusCode == '000000') {
                    $this->session->set('auth', $re->content);
                    return $this->response->redirect($reUrl);
                } else {
                    $this->flash->error($re->statusMsg);
                }
            } else {
                $this->flash->error("token errors");
            }
        }
    }

    public function getcodeAction()
    {
        $mobile = $this->request->getPost('mobile');
        $webApi = new WebapiComponent();
        $re = $webApi->webApiGetCode($mobile);
        echo $re;
        exit;
    }

    function userRegister($user, $mobile)
    {
        $code = $this->session->get('code');
        if ($user) {
            $user->password = $this->security->hash($code);
            if ($user->save()) {
                return true;
            }
        } else {
            $HdUser = new HdUser();
            $HdUser->mobile = $mobile;
            $HdUser->username = $mobile;
            $HdUser->password = $this->security->hash($code);
            $HdUser->update_time = date("Y-m-d H:i:s");
            $HdUser->create_time = date("Y-m-d H:i:s");
            if ($HdUser->save()) {
                return true;
            }
        }
        return false;
    }
}
