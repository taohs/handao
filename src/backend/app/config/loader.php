<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir,
        $config->application->helperDir,
        $config->application->libraryDir,
        $config->application->libraryDir . 'user/',
        $config->application->libraryDir . 'user/login',
    )
)->register();
