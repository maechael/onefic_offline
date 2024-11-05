<?php

use yii\i18n\Formatter;
use yii\rbac\DbManager;
use yii\web\AssetConverter;
use kartik\mpdf\Pdf;
use yii\queue\LogBehavior;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'name' => 'FICPhil',
    'id' => 'FICPhil.Local',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['queue', 'log',],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@api' => 'http://ficphil.api.local.test/v1',
        '@server' => 'https://test.ficphil.com/',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lZQjYIINYlaJoyV3Okk6mRHWQLYpFrjB',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['auth/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        [
            'class' => Formatter::class,
            'timezone' => 'Asia/Singapore'
        ],
        'formatter' => [
            'currencyCode' => '₱',
        ],
        'db' => $db,
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            // 'path' => '@runtime/queue', // only for file queue
            'ttr' => 3 * 60, // Max time for job execution
            'attempts' => 5, // Max number of attempts
            'as log' => LogBehavior::class,
            'db' => 'db',
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'pdf' => [
            'class' => Pdf::class,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
            'converter' => [
                'class' => AssetConverter::class,
                'commands' => [
                    'scss' => ['css', 'C:\Users\DOST-ITDI\AppData\Roaming\npm\sass --style=compressed {from} {to}']
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager' => [
            'class' => DbManager::class, // yii\rbac\PhpManager or 'yii\rbac\DbManager'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    //'@app/views' => '@vendor/hail812/yii2-adminlte3/src/views',
                    '@mdm/admin/views' => '@app/views/administrator',
                ],
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            // '*',
            'auth/login',
            'auth/logout',
            'tech-service/get-tech-service',
            'sync/*',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    //'userClassName' => 'app\models\User',
                    //'idField' => 'id',
                    'usernameField' => 'username',
                    'fullnameField' => 'userProfile.firstname',
                    'extraColumns' => [
                        [
                            'attribute' => 'userProfile',
                            'label' => 'Designation',
                            'value' => 'userProfile.designation.description'
                        ]
                    ],
                ]
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
        'generators' => [
            'job' => [
                'class' => \yii\queue\gii\Generator::class
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
