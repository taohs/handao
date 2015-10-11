<?php

use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 * @property $config Phalcon\Config
 */
class ControllerBase extends Controller
{

    public $auth;

    const ORIGIN = 'backend';

    /**
     * @inheritdoc
     * 初始化方法
     */
    public function initialize()
    {
        $this->view->setLayout('main');
        $this->forceLogin();
        $this->auth = $this->getAuth();

        $this->view->setVar('controllerName',$this->dispatcher->getControllerName());
        $this->view->setVar('auth',$this->auth);

    }

    /**
     * every operate need login;
     */
    public function forceLogin()
    {
        if (!$this->checkLogin()) {
            if ($this->request->isAjax()) {
                $json = array(
                    'rel' => false,
                    'message' => 'you should login the system;',
                    'link' => array(
                        'title' => 'click to login page',
                        'message' => 'click to login page',
                        'href' => $this->url->get('sign/index'),
                        'class' => ''
                    )
                );

                echo json_encode($json);
                exit;
            } else {
                return $this->response->redirect('sign/index');
            }
        }
    }

    /**
     * @return bool
     */
    public function checkLogin()
    {
        return $this->getAuth() ? true : false;
    }


    /**
     * @return HdAdmin|bool
     */
    public function getAuth()
    {
        return $this->session->get($this->config->session->loginKey);
    }

    /**
     *
     *
     * array_slice() 函数在数组中根据条件取出一段值，并返回。
     * 注释：如果数组有字符串键，所返回的数组将保留键名。（参见例子 4）
     * 语法
     * array_slice(array,offset,length,preserve)
     * 参数    描述
     * array    必需。规定输入的数组。
     * offset
     * 必需。数值。规定取出元素的开始位置。
     * 如果是正数，则从前往后开始取，如果是负值，从后向前取 offset 绝对值。
     * length
     * 可选。数值。规定被返回数组的长度。
     * 如果 length 为正，则返回该数量的元素。
     * 如果 length 为负，则序列将终止在距离数组末端这么远的地方。
     * 如果省略，则序列将从 offset 开始直到 array 的末端。
     * preserve
     * 可选。可能的值：
     * true - 保留键
     * false - 默认 - 重置键
     *
     * @param $uri 定义和用法
     */
    public function forward($uri)
    {
        if (is_array($uri)) {
            $uriParts = implode('/', $uri);
            $params = array_slice($uriParts, 2);
            return $this->dispatcher->forward(
                array(
                    'controller' => $uriParts['0'],
                    'action' => $uriParts['1'],
                    'params' => $params
                )
            );
        }
    }

    /**
     * 重新刷新
     */
    public function refresh(){
        return $this->response->redirect($this->request->getURI());
    }

    protected function _getModel($id)
    {
        $id = $this->filter->sanitize($id, \Phalcon\Filter::FILTER_INT_CAST);
        $model = HdBrands::findFirst($id);
        if (!$model) {
            throw new \Phalcon\Mvc\Model\Exception("对象不存在");
        }
        return $model;
    }

    public function now(){
        return date('Y-m-d H:i:s');
    }
}
