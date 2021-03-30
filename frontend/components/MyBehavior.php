<?php

namespace frontend\components;

use yii\base\Behavior;

class MyBehavior extends Behavior
{
    public $prop1;
    private $_prop2;
    private $_prop3;

    //行为的只读属性
    public function getProp2()
    {
        return $this->_prop2;
    }

    //行为的只写属性
    public function setProp3($prop3)
    {
        $this->_prop3 = $prop3;
    }

    //行为的方法
    public function foo()
    {
        return 'foo';
    }

    protected function bar()
    {
        return 'bar';
    }

    // 需要按事件绑定的方式来定义add，
    // $this->on(self::EVENT_USER_LOGIN,['frontend\components\MyBehavior','add']) 代表静态调用，所以需要static
    public static function add($event)
    {
        \Yii::error('我是MyBehavior->add，触发了，数据：' . var_export($event->data, true));
    }

    public static function send($event)
    {
        \Yii::error('我是MyBehavior->send，触发了');
    }
}