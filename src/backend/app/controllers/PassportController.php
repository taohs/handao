<?php

class PassportController extends ControllerBase
{

    public function indexAction()
    {
        /**
         * @var $user HdAdmin
         */
        $user = $this->session->get($this->config->session->loginKey);

        if (!$user) {
            throw new \Phalcon\Exception("请重新登录");
            return $this->response->redirect('sign/out');
        }

        if ($this->request->isPost()) {

            $oldPassword = $this->request->getPost('oldPassword', \Phalcon\Filter::FILTER_STRING);
            $newPassword = $this->request->getPost('newPassword', \Phalcon\Filter::FILTER_STRING);
            $confirmPassword = $this->request->getPost('confirmPassword', \Phalcon\Filter::FILTER_STRING);

            if ($newPassword != $confirmPassword) {
                $this->flash->error('确认密码必须和新密码一致');
                return $this->refresh();
            }


            if ($this->security->checkHash($oldPassword, $user->password)) {
                $user->password = $this->security->hash($newPassword);
                if($user->save()){
                    $this->flash->success('修改成功');
                }else{
                    $this->flash->error('修改失败');
                }
                return $this->refresh();
            }else{
                $this->flash->error('密码错误');
                return $this->refresh();
            }
        }
    }


}

