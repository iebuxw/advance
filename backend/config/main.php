<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
//    'timeZone'=>'Asia/Shanghai',
    'language' =>'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\Adminuser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],// 不记录参数
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

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
    'params' => $params,// 全局访问的参数，代替硬编码，不过没有宏好用
];
