<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/*
 * 参数是把值传给动作的形参
 * 选项是把值传给声明的属性
 */
class HelloController extends Controller
{
    public $rev;

    // 定义选项
    public function options($actionID)
    {
        return ['rev'];
    }

    // 选项别名
    public function optionAliases()
    {
        return ['r' => 'rev'];
    }

//    yii hello aaaaa bbbbbbb
    public function actionIndex($a, $b)
    {
        var_dump($a);
        var_dump($b);
        echo 'hello world!';
    }

    //    yii hello/test
    public function actionTest()
    {
        echo 'hello world!';
    }

    //    yii hello/test2 2222,333333
    public function actionTest2(array $a)
    {
        var_dump($a);
        echo 'hello world!';
    }

//    yii hello/test3 world --rev 1
//    yii hello/test3 world -r 1
//    yii hello/test3 world
//    yii hello/test3
    public function actionTest3($a = 'hello')
    {
        if (1 == $this->rev) {
            echo strrev($a);
        } else {
            echo $a;

            return 1;// 失败
        }

        return 0;// 成功
    }
}