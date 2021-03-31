<?php

//注意这里的命名空间，要跟你的目录对应
namespace frontend\components;

use yii\base\Action;

//我们需要继承yii\base\Action类
class TestAction extends Action
{
    //这里面的三个参数的值是通过控制器actions中配置而来的
    public $param1 = null;
    public $param2 = null;
    public $param3 = null;

    //实现run方法
    public function run()
    {
        echo "test run param1: {$this->param1} param2: {$this->param2} param3: {$this->param3}";
    }
}