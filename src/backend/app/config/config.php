<?php

defined( 'APP_PATH' ) || define( 'APP_PATH', realpath( '.' ) );

return new \Phalcon\Config( array(
    'database'    => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'Xds2hL9al46FnXjx',
        'dbname'   => 'myautodb',
        'charset'  => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'componentsDir'      => APP_PATH . '/app/components/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'helperDir'      => APP_PATH . '/app/helper/',
        'cacheDir'       => APP_PATH . '/cache/',
        'baseUri'        => '/',
        'formsDir'       => APP_PATH . '/app/forms/'
    ),
    'session'     => array(
        'loginKey' => 'auth'
    ),
    'paginate'    => array(
        'limit' => 10
    ),
    'user'        => array(
        'password' => array(
            'default'   => '123456',
            'minLength' => '6',
            'maxLength' => '20'
        )
    ),
    'api'=>array(
        'gateway'=>'http://api.handao365.com/'
    )
) );
