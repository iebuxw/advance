<?php

namespace frontend\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class MyBehavior2 extends Behavior
{
    // 重载events() 使得在事件触发时，调用行为中的一些方法
    public function events()
    {
        // 在EVENT_BEFORE_VALIDATE事件触发时，调用成员函数 beforeValidate
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    // 注意beforeValidate 是行为的成员函数，而不是绑定的类的成员函数。
    // 还要注意，这个函数的签名，要满足事件handler的要求。
    public function beforeValidate($event)
    {
        \Yii::error('验证触发了');
    }
}