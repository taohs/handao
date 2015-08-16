<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/15/15
 * Time: 11:11
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/15/15  Time: 11:11
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

use Phalcon\Acl;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    public function beforeDispatch(Event $event,Dispatcher $dispatcher){

    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {

        // Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Take the active controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // Obtain the ACL list
        $acl = $this->getAcl();

        // Check if the Role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW) {

            // If he doesn't have access forward him to the index controller
            $this->flash->error("You don't have access to this module");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action'     => 'index'
                )
            );

            // Returning "false" we tell to the dispatcher to stop the current operation
            return false;
        }

    }

}
