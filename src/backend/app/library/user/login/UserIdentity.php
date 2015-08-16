<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 14:59
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 14:59
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
class UserIdentity  implements SplSubject
{
    /**
     * @var $di \Phalcon\Di\FactoryDefault
     */
    public $di;
    private $storage;

    const ERROR_NONE=0;
    const ERROR_USERNAME_INVALID=1;
    const ERROR_PASSWORD_INVALID=2;
    const ERROR_UNKNOWN_IDENTITY=100;

    /**
     * @var string username
     */
    public $username;
    /**
     * @var string password
     */
    public $password;

    /**
     * @var integer the authentication error code. If there is an error, the error code will be non-zero.
     * Defaults to 100, meaning unknown identity. Calling {@link authenticate} will change this value.
     */
    public $errorCode=self::ERROR_UNKNOWN_IDENTITY;
    /**
     * @var string the authentication error message. Defaults to empty.
     */
    public $errorMessage='';

    private $_state=array();


    function __construct($username,$password)
    {
        // TODO: Implement __construct() method.
        $this->username=$username;
        $this->password=$password;
        $this->storage = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function notify()
    {
        foreach ($this->storage as $obs) {
            $obs->update($this);
        }
    }

    /**
     * Returns the identity states that should be persisted.
     * This method is required by {@link IUserIdentity}.
     * @return array the identity states that should be persisted.
     */
    public function getPersistentStates()
    {
        return $this->_state;
    }

    /**
     * Sets an array of persistent states.
     *
     * @param array $states the identity states that should be persisted.
     */
    public function setPersistentStates($states)
    {
        $this->_state = $states;
    }

    /**
     * Returns a value indicating whether the identity is authenticated.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether the authentication is successful.
     */
    public function getIsAuthenticated()
    {
        return $this->errorCode==self::ERROR_NONE;
    }

    /**
     * Gets the persisted state by the specified name.
     * @param string $name the name of the state
     * @param mixed $defaultValue the default value to be returned if the named state does not exist
     * @return mixed the value of the named state
     */
    public function getState($name,$defaultValue=null)
    {
        return isset($this->_state[$name])?$this->_state[$name]:$defaultValue;
    }

    /**
     * Sets the named state with a given value.
     * @param string $name the name of the state
     * @param mixed $value the value of the named state
     */
    public function setState($name,$value)
    {
        $this->_state[$name]=$value;
    }

    /**
     * Removes the specified state.
     * @param string $name the name of the state
     */
    public function clearState($name)
    {
        unset($this->_state[$name]);
    }

    public function authenticate()
    {
        $security = $this->di->getShared('security');
//        $session  = $this->di->getShared('session');
        $admin = HdAdmin::findFirst(
            array(
                'conditions' => 'username=:username:',
                'bind' => array(
                    'username' => $this->username
                )
            ));
        if ($admin && $security->checkHash($this->password, $admin->password)) {

//            $session->set($this->config->session->loginKey, $admin);
            //change the password in the database with hash different from earlier
            //This situation should use the observer pattern
            //$admin->password = $this->security->hash($password);
            //$admin->save();
            $this->errorCode = self::ERROR_NONE;
            $this->setState('admin',$admin);
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
    }
}