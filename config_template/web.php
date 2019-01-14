<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'riac',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-Ru',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'tehdoc' => [
            'class' => 'app\modules\tehdoc\TehdocModule',
        ],
        'to' => [
            'class' => 'app\modules\to\ToModule',
        ],
        'people' => [
            'class' => 'app\modules\people\PeopleModule',
        ],
        'doc' => [
            'class' => 'app\modules\doc\DocModule',
        ],
        'sysi' => [
            'class' => 'app\modules\sysi\SysiModule',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
          // other module settings, refer detailed documentation
        ]
    ],
    'components' => [
        'request' => [
          // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\admin\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/site/login'         // возможность переопределить страницу аутентификации
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
      // менеджер RBAC
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
      // менеджер ресурсов - гибко управляет подключаемыми библиотеками
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => false,
//                'yii\web\YiiAsset' => false,
//                'linkAssets' => true,   // TODO Возможно операционная система сервера не разрешит ссылки!
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
          // send all mails to a file by default. You have to set
          // 'useFileTransport' to false and configure a transport
          // for the mailer to send real emails.
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '',
            'rules' => [
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
    'allowedIPs' => ['', '::1.php'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
      'allowedIPs' => ['', '::1.php'],
  ];
}

return $config;
