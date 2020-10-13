<?php

use app\components\gateway\PayPingGateway;
use \yii\web\Request;
use app\components\Setting;

Yii::setAlias('@webapp', rtrim(str_replace("public_html", "", (new Request)->getBaseUrl()), '/'));

$baseUrl = (new Request)->getBaseUrl();

$params = require_once __DIR__ . '/params.php';
$db = require_once __DIR__ . '/db.php';
require_once(__DIR__ . '/../components/Setting.php');
require_once(__DIR__ . '/../yii_helper.php');

$config = [
    'id' => 'basic',
    'name' => 'App Name',
    'basePath' => dirname(__DIR__),
    'language' => 'ar',
    'timeZone' => Setting::get('timeZone'),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ],
                ],
                'yii\jui\JuiAsset' => [
                    'js' => [
                        'jquery-ui.min.js'
                    ],
                    'css' => [
                        'themes/smoothness/jquery-ui.min.css'
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'j5stjE4_Z4MGofmiwRkw0mxmR2Do2RNE',
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'options' => [
                        'fontDir' => __DIR__ . '/../../public_html/themes/frontend/fonts/IranSans/ttf',
                        'fontdata' => [
                            'iransans' => [
                                'R' => 'IRANSansWeb.ttf',
                                'B' => 'IRANSansWeb_Bold.ttf',
                                'useOTL' => 0xFF,
                                'useKashida' => 75,
                            ]
                        ],
                        'autoScriptToLang' => true,
                        'autoLangToFont' => true,
                    ],
                    'defaultFont' => 'iransans',
                ],
            ]
        ],
        'gateway' => [
            'class' => PayPingGateway::className(),
            'token' => 'e4145b056c3ab27537d6519d8d08a0718f0f37465c9993b583574d7038d38a0d',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'authTimeout' => 3600,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'server380.bertina.biz',
                'username' => 'noreply@rezvan.info',
                'password' => ',4E8JZ*#;OD=',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'app\components\MultilingualUrlManager',
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'dashboard' => 'user/dashboard',
                'contact' => 'site/contact',
                '<language:\w{2}>' => 'site/change-lang',
                '<language:\w{2}>/<controller:\w+>' => 'site/change-lang',
                '<language:\w+>/<controller:\w+>/<action:\w+>' => 'site/change-lang',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>/<title:.*>' => '<controller>/<action>',
                'request' => 'request/new',
                '<controller:\w+>' => '<controller>/index',
                '<language:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        'view' => [
            'class' => 'app\components\CustomView',
            'theme' => [
                'basePath' => '@webroot/themes/frontend',
                'baseUrl' => '@web/themes/frontend',
            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'actions' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'words' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [ //here
            'controller' => [ // generator name
                'class' => 'app\giigenerators\controller\Generator', // generator class
                'templates' => [ //setting for out templates
                    'default' => '@app/giigenerators/controller/default', // template name => path to template
                ]
            ],
            'crud' => [ // generator name
                'class' => 'app\giigenerators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'default' => '@app/giigenerators/crud/default', // template name => path to template
                ]
            ],
            'model' => [ // generator name
                'class' => 'app\giigenerators\model\Generator', // generator class
                'templates' => [ //setting for out templates
                    'default' => '@app/giigenerators/model/default', // template name => path to template
                ]
            ]
        ],
    ];
}

return $config;