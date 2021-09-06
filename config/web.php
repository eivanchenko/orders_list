<?php
/* @var codemix\yii2confload\Config $this */

// Prepare bootstrapped components and modules
$bootstrap = ['log'];   // Must be 1st bootstrapped component
$modules = [
    'orders' => [
        'class' => 'orders\OrdersModule'
    ],
];
if (YII_ENV_DEV) {
    $bootstrap[] = 'debug';  // Must be 2nd bootstrapped component
    $bootstrap[] = 'gii';
    $modules['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $modules['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return [
    'id' => 'basic',
    'name' => $_ENV['COMPOSE_PROJECT_NAME'],
    'aliases' => [
        '@bower' => '/var/www/vendor/bower-asset',
        '@npm' => '/var/www/vendor/npm-asset',
        '@orders' => '/var/www/html/modules/orders',
        '@ordersUrl'=> 'orders/index'

    ],
    'defaultRoute' => 'orders/orders/index',
    'basePath' => '/var/www/html',
    'language' => 'en',
    'bootstrap' => $bootstrap,
    'modules' => $modules,
    'vendorPath' => '/var/www/html/vendor',
    'catchAll' => self::env('MAINTENANCE', false) ? ['site/maintenance'] : null,
    'components' => [
        'cache' => self::env('DISABLE_CACHE', false) ?
            'yii\caching\DummyCache' :
            [
                'class' => 'yii\caching\ApcCache',
                'useApcu' => true,
            ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $_ENV['DOCKER_CONTAINER_NAME_DB'] . ';dbname=' . $_ENV['DB_NAME'],
            'username' => self::env('DB_USER'),
            'password' => self::env('DB_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'orders/orders/error'
        ],
        'log' => [
            'traceLevel' => self::env('YII_TRACELEVEL', 0),
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stdout',
                    'logVars' => [],
                    'levels' => ['info', 'trace'],
                    'except' => self::env('WEB_LOG_YII', 0) ? [] : ['yii\*'],
                    'exportInterval' => 1,
                    'disableTimestamp' => true,
                    'prefixString' => '[yii-web]',
                ],
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stderr',
                    'logVars' => [],
                    'levels' => ['error', 'warning'],
                    'except' => self::env('WEB_LOG_YII', 0) ? [] : ['yii\*'],
                    'exportInterval' => 1,
                    'disableTimestamp' => true,
                    'prefixString' => '[yii-web]',
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => self::env('COOKIE_VALIDATION_KEY', null, !YII_ENV_TEST),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/orders' => 'orders/orders/index',
                // '<module>:\w+' => '<module>'

            ]

        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/modules/orders/messages',
                ],
            ]
        ]
    ],
    'params' => [],
];
