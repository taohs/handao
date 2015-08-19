<?php

/**
 * Class AdminController
 */
class AdminController extends ControllerBase
{
    const SUPER_ADMIN_ID = 1;
    const SUPER_ADMIN_ROLE = 1;

    /**
     * 后台人员管理
     */
    public function indexAction()
    {
        return $this->response->redirect($this->dispatcher->getControllerName().'/list');
    }

    public function listAction()
    {
        $admins = HdAdmin::find(array());
        $page = $this->request->getQuery('page', 'int'); // GET
        $paginateModel = new Phalcon\Paginator\Adapter\Model(array(
            'data' => $admins,
            'limit' => $this->config->paginate->limit,
            'page' => $page
        ));
        $this->view->setVar('paginate', $paginateModel->getPaginate());
//        $this->view->setVar('page', $page);
    }

    public function createAction()
    {
//        $admin = $this->_getModel($id);

        if ($this->request->isPost()) {
            $inputUsername = $this->request->getPost('inputUsername', \Phalcon\Filter::FILTER_EMAIL);
            $inputPassword = $this->request->getPost('inputPassword', \Phalcon\Filter::FILTER_STRING);
            $inputConfirmPassword = $this->request->getPost('inputConfirmPassword', \Phalcon\Filter::FILTER_STRING);
            $inputRole = $this->request->getPost('inputRole', \Phalcon\Filter::FILTER_INT_CAST);
            $inputIs_valid = $this->request->getPost('inputIs_valid', \Phalcon\Filter::FILTER_ALPHANUM);

            if (!filter_var($inputUsername, FILTER_VALIDATE_EMAIL)) {
                $this->flash->error("用户名必须为邮箱");
                return $this->refresh();
            }
            if (strlen($inputPassword) < 6 or strlen($inputPassword) > 20) {
                $this->flash->error("请输入六至二十位的新密码");
                return $this->refresh();
            }
            if (strlen($inputConfirmPassword) < 6 or strlen($inputConfirmPassword) > 20) {
                $this->flash->error("请输入六至二十位的重复密码");
                return $this->refresh();
            }
            if ($inputPassword !== $inputConfirmPassword) {
                $this->flash->error("重复输入密码与新密码不一致");
                return $this->refresh();
            }

            $confirmAdmin = HdAdmin::findFirst(array(
                'conditions' => 'username=:username:',
                'bind' => array('username' => $inputUsername)
            ));

            if($confirmAdmin){
                $this->flash->error('该邮箱已经被注册成为管理员用户名');
                return $this->refresh();
            }


            /**
             * limit and data validate
             */
            $this->_mustSuperAdminRole();//只有超级管理员才能新建管理员
            $role = $this->_getRole($inputRole);//取角色数据，如果取不到自动抛出错误;

            $admin = new HdAdmin();
            $admin->username = $inputUsername;
            $admin->password = $this->security->hash($inputPassword);
            $admin->role = $role->id;
            $admin->is_valid = is_null($inputIs_valid) ? 0 : 1;
            $admin->save();
            $this->flash->success("提交保存成功");
            return $this->refresh();
        }

        $adminRole = HdAdminRole::find(array('conditions' => 'is_valid=1'));
        $this->view->setVar('adminRole', $adminRole);
    }

    public function deleteAction($id)
    {

        $auth = $this->getAuth();
        $limitArray = explode(',', $auth->limit);

        if (in_array('admin_delete', $limitArray)) {

            $admin = $this->_getModel($id);
            $this->_mustSuperAdminRole();
            if (self::SUPER_ADMIN_ID == $admin->id) {
                throw new \Phalcon\Acl\Exception("不能删除超级管理员");
            }

            if (self::SUPER_ADMIN_ROLE == $admin->role && self::SUPER_ADMIN_ID != $auth->id) {
                throw new \Phalcon\Acl\Exception("您不是超级管理员，不能删除超级管理员角色");
            }
            try {
                $admin->delete();
            } catch (\Exception $e) {

            }
        } else {
            throw new \Phalcon\Acl\Exception("权限不足");
        }
    }

    public function profileAction()
    {

    }

    public function passwordAction()
    {

        $auth = $this->getAuth();

        $admin = $this->_getModel($auth->id);


        if ($this->request->isPost()) {
            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT_CAST);
            $inputOldPassword = $this->request->getPost('inputOldPassword', \Phalcon\Filter::FILTER_STRING);
            $inputNewPassword = $this->request->getPost('inputNewPassword', \Phalcon\Filter::FILTER_STRING);
            $inputConfirmPassword = $this->request->getPost('inputConfirmPassword', \Phalcon\Filter::FILTER_STRING);

            /**
             * security validate
             */
            if ($inputId != $auth->id or $inputId != $admin->id) {
                throw new \Phalcon\Forms\Exception("提交信息不匹配");
            }
            /**
             * form validate
             */
            if (strlen($inputOldPassword) < 6 or strlen($inputOldPassword) > 20) {
                $this->flash->error("请输入六至二十位的旧密码");
                return $this->refresh();
//                return false;
            }
            if (strlen($inputNewPassword) < 6 or strlen($inputNewPassword) > 20) {
                $this->flash->error("请输入六至二十位的新密码");
                return $this->refresh();
            }
            if (strlen($inputConfirmPassword) < 6 or strlen($inputConfirmPassword) > 20) {
                $this->flash->error("请输入六至二十位的重复密码");
                return $this->refresh();
            }
            if ($inputNewPassword !== $inputConfirmPassword) {
                $this->flash->error("重复输入密码与新密码不一致");
                return $this->refresh();
            }
            if (!$this->security->checkHash($inputOldPassword, $admin->password)) {
                $this->flash->error("旧密码输入错误");
                return $this->refresh();
            }
            $admin->password = $this->security->hash($inputNewPassword);
            $admin->save();
            $this->flash->success("提交保存成功");
            return $this->refresh();
        }

        $adminRole = HdAdminRole::find(array('conditions' => 'is_valid=1'));

        $this->view->setVar('admin', $admin);
        $this->view->setVar('adminRole', $adminRole);
    }

    public function updateAction($id)
    {
        $admin = $this->_getModel($id);

        if ($this->request->isPost()) {
            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT_CAST);
            $inputRole = $this->request->getPost('inputRole', \Phalcon\Filter::FILTER_INT_CAST);
            $inputIs_valid = $this->request->getPost('inputIs_valid', \Phalcon\Filter::FILTER_ALPHANUM);

            if ($inputId != $id or $inputId != $admin->id) {
                throw new \Phalcon\Forms\Exception("提交信息不匹配");
            }

            $this->_mustSuperAdminRole();

            $role = $this->_getRole($inputRole);//取角色数据，如果取不到自动抛出错误;

            $admin->role = $role->id;
            $admin->is_valid = is_null($inputIs_valid) ? 0 : 1;
            $admin->save();
            $this->flash->success("提交保存成功");
            return $this->refresh();
        }

        $adminRole = HdAdminRole::find(array('conditions' => 'is_valid=1'));

        $this->view->setVar('admin', $admin);
        $this->view->setVar('adminRole', $adminRole);
    }

    public function resetAction($id)
    {
        $admin = $this->_getModel($id);

        if ($this->request->isPost()) {
            $inputId = $this->request->getPost('inputId', \Phalcon\Filter::FILTER_INT_CAST);

            if ($inputId != $id or $inputId != $admin->id) {
                throw new \Phalcon\Forms\Exception("提交信息不匹配");
            }
            $this->_mustSuperAdminRole();

            $admin->password = $this->security->hash($this->config->user->password->default);
            $admin->save();
            $this->flash->success("提交保存成功");
            $this->refresh();
            return false;
        }

        $adminRole = HdAdminRole::find(array('conditions' => 'is_valid=1'));

        $this->view->setVar('admin', $admin);
        $this->view->setVar('adminRole', $adminRole);
    }

    protected function _getModel($id)
    {
        $id = $this->filter->sanitize($id, \Phalcon\Filter::FILTER_INT_CAST);
        $admin = HdAdmin::findFirst($id);

        if (!$admin) {
            throw new \Phalcon\Mvc\Model\Exception("对象不存在");
        }
        return $admin;
    }

    protected function _getRole($id)
    {
        $id = $this->filter->sanitize($id, \Phalcon\Filter::FILTER_INT_CAST);
        $role = HdAdminRole::findFirst($id);

        if (!$role) {
            throw new \Phalcon\Mvc\Model\Exception("对象不存在");
        }
        return $role;
    }

    /**
     * 必须超级管理员才能执行
     * @return bool|HdAdmin
     * @throws \Phalcon\Acl\Exception
     */
    protected function _mustSuperAdminRole()
    {
        $auth = $this->getAuth();
        if ($auth->role != self::SUPER_ADMIN_ROLE) {
            $this->flash->error("权限不够");
            $this->refresh();
            throw new \Phalcon\Acl\Exception("权限不够");
        }
        return $auth;
    }
}

