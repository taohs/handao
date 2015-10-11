<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;

use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;


/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    //files
    $session = new SessionAdapter();
    if (!$session->isStarted()) {
        $session->start();
    }
    return $session;

//    redis
//    $session = new \Phalcon\Session\Adapter\Redis(array(
//        'uniqueId' => 'my-private-app',
//        'host' => '127.0.0.1',
//        'port' => 6379,
////        'auth' => 'foobared',
//        'persistent' => false,
//        'lifetime' => 3600,
//        'prefix' => 'my_'
//    ));
//    if (!$session->isStarted()) {
//        $session->start();
//    }
//    $session->set('var', 'some-value');
//
//    return $session;

//    $session = new Phalcon\Session\Adapter\Libmemcached(array(
//        'servers' => array(
//            array('host' => 'localhost', 'port' => 11211, 'weight' => 1),
//        ),
//        'client' => array(
//            Memcached::OPT_HASH => Memcached::HASH_MD5,
//            Memcached::OPT_PREFIX_KEY => 'prefix.',
//        ),
//        'lifetime' => 3600,
//        'prefix' => 'my_'
//    ));
//    $session->start();
//    $session->set('var', 'some-value');
});
$di->setShared('flash', function () {
    return new FlashSession(array(
        'error' => 'alert alert-danger',
        'notice' => 'alert alert-info',
        'success' => 'alert alert-success',
        'warning' => 'alert alert-warning',
    ));
});
$di->setShared('cache', function () {

});

$di->setShared('config', $config);


$di->setShared('dispatcher', function () {

    $eventsManager = new EventsManager();
    /**
     * Check if the user is allowed to access certain action using the SecurityPlugin
     */
    $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);

    $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {

        if ($exception instanceof DispatcherException) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward([
                        'controller' => 'errors',
                        'action' => 'show404',
                        'params' => array('message' => $exception->getMessage())
                    ]);
                    return false;
            }
        }

        $dispatcher->forward([
            'controller' => 'errors',
            'action' => 'show500',
            'params' => array(
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            )
        ]);
        return false;
    });

    $dispatcher = new MvcDispatcher();
//    $dispatcher->setDefaultNamespace('');
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

$di->setShared('element', function () {
    return new Element();
});
$di->setShared('restful', function () {
    $restful = new Restful();
    $restful->initialize();

    return $restful;
});
