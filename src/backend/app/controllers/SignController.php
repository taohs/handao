<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/13/15
 * Time: 22:30
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/13/15  Time: 22:30
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

/**
 * Class SignController
 */
class SignController extends ControllerBase
{
    /**
     * 初始化
     *
     */
    public function initialize()
    {

        $this->tag->prependTitle("handao365");
        $this->view->setMainView('login');
        $this->view->setLayout('empty');
    }

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function onConstruct()
    {
        // TODO: Implement __construct() method.
    }


    public function indexAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {

                $username = $this->request->getPost('inputEmail', 'email');
                $password = $this->request->getPost('inputPassword', 'string');
                $admin = HdAdmin::findFirst(
                    array(
                        'conditions' => 'username=:username:',
                        'bind' => array(
                            'username' => $username,
//                            'password' => $this->validPassword($password)
                        )
                    ));
                if ($admin && $this->security->checkHash($password,$admin->password)) {
                    $this->session->set($this->config->session->loginKey, $admin);

                    //change the password in the database with hash different from earlier
                    //This situation should use the observer pattern
                    //$admin->password = $this->security->hash($password);
                    //$admin->save();
                    return $this->response->redirect('index/index');
                } else {
                    $this->flash->error("password errors");
                }
            } else {
                $this->flash->error("password errors");
            }
        }
    }



    /**
     * deal form post
     *
     */
    public function inAction()
    {
        if ($this->security->checkToken()) {
            $username = $this->request->getPost('inputEmail', 'email');
            $password = $this->request->getPost('inputPassword', 'string');

            $admin = HdAdmin::findFirst(
                array(
                    'conditions' => 'username=:username: and password=:password:',
                    'bind' => array(
                        'username' => $username,
                        'password' => $this->validPassword($password)
                    )
                ));
            if ($admin) {
                $this->session->set($this->config->session->loginKey, $admin);
                return $this->response->redirect('index/index');
            }

        }
        $this->flash->error("password errors");
        return $this->response->redirect('sign/index');
    }

    /**
     *
     */
    public function outAction()
    {
        $this->session->destroy();
        $this->forceLogin();
    }

    public function validPassword($password = null)
    {
        if (is_null($password))
            throw new \Phalcon\Forms\Exception("password is null", E_USER_ERROR);
        return sha1($password);
    }

    public function changePassword($password = null, $salt = null)
    {

    }

}

