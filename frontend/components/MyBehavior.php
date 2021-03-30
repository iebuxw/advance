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

}