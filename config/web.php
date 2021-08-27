<?php
/* @var codemix\yii2confload\Config $this */

// Prepare bootstrapped components and modules
$bootstrap = ['log'];   // Must be 1st bootstrapped component
$modules = [
    'orders' => [
        'class' => 'app\modules\orders\OrdersModule'
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
    'aliases' => [
        '@bower' => '/var/www/vendor/bower-asset',
        '@npm' => '/var/www/vendor/npm-asset',
    ],
    'defaultRoute' => 'orders/default/index',
    'basePath' => '/var/www/html',
    'language' => 'en',
    'bootstrap' => $bootstrap,
    'modules' => $modules,
    'vendorPath' => '/var/www/vendor',
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
            'dsn' => self::env('DB_DSN', 'mysql:host=' . GlobalsConst::DB_HOST . ';dbname=' . GlobalsConst::DB_NAME),
            'username' => self::env('DB_USER', GlobalsConst::DB_USER),
            'password' => self::env('DB_PASSWORD', GlobalsConst::DB_PASSWORD),
            'charset' => 'utf8',
            'tablePrefix' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'orders/default/error',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => self::env('SMTP_HOST'),
                'username' => self::env('SMTP_USER'),
                'password' => self::env('SMTP_PASSWORD'),
                'port' => self::env('SMTP_PORT', 25),
                'encryption' => self::env('SMTP_ENCRYPTION', null),
            ],
        ],
        'request' => [
            'cookieValidationKey' => self::env('COOKIE_VALIDATION_KEY', null, !YII_ENV_TEST),
            'trustedHosts' => explode(',', self::env('PROXY_HOST', '192.168.0.0/24')),
        ],
        'session' => [
            'name' => 'MYAPPSID',
            'savePath' => '@app/var/sessions',
            'timeout' => 1440,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'orders/default/index',
                'orders' => 'orders/default/index'
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'formatter' => [
            'dateFormat' => 'yyyy-mm-dd hh:mm:ss',

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
    'params' => [
        'mail.from' => ['no-reply@example.com' => 'My Application'],
        'mail.catchAll' => self::env('MAIL_CATCHALL', null),

        'user.passwordResetTokenExpire' => 3600,
        'user.emailConfirmationTokenExpire' => 43200, // 5 days
    ],
];
