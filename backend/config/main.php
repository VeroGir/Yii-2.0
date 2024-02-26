<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

use kartik\datecontrol\Module;

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'ru',
    'bootstrap' => ['log'],
    'modules' => [
        'blog' => [
            'class' => 'common\modules\blog\Blog',
        ],

        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            'displaySettings' => [
                Module::FORMAT_DATE => 'php: d-M-Y',
                Module::FORMAT_TIME => 'php: H:i',
                Module::FORMAT_DATETIME => 'php: d-M-Y H:i',
            ],

            'saveSettings' => [
                Module::FORMAT_DATE => 'yyyy-M-dd',
                Module::FORMAT_TIME => 'H:i:s',
                Module::FORMAT_DATETIME => 'yyyy-M-dd H:i:s',
            ],

            'displayTimezone' => 'Asia/Kolkata',

            'saveTimezone' => 'UTC',

            'autoWidget' => true,
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 4 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'language' => 'ru',
            'dateFormat' => 'php: d-M-Y',
            'datetimeFormat' => 'php: d-M-Y H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],

    ],
    'params' => $params,
];
