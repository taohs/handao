<?php
/**
 * set the all env variable
 * @error level
 * @const variable
 *      #app_path
 *      #app_root
 *      #app_vendor
 */
error_reporting(E_ALL);

define('APP_PATH', realpath('..'));
define('APP_ROOT',realpath('../../../'));
define('APP_VENDOR',APP_ROOT.'/vendor');


try {

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
