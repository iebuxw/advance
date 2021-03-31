<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => '读书笔记',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'excerpt/index',
    'language' =>'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['rhythmk'],
//                    'logFile' => '@app/runtime/logs/Mylog/requests.log',
                    'levels' => ['error', 'warning', 'info'],
                    'logVars' => [],// 不记录参数
                    "maxFileSize" =>  10240,// 10M
                    "maxLogFiles" =>  10
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            'enablePrettyUrl' => true,//美化
            'showScriptName' => false,//index.php
//            'suffix' => '.html',//后缀
            'rules'=>array(
                // 详情  post/10  ===>  (controller参数为post，id参数为10)  ===>  post/view  且参数为id=10
                // 参数设置格式为 <ParamName:RegExp>
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                // id更新
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                // 其他
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ],
    ],
    'params' => $params,
];
