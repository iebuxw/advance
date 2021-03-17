<?php

namespace app\modules\admin\controllers;

use backend\controllers\BaseController;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
//        dd(\Yii::$app->formatter->format('2014-01-01', 'date'));// 2014年1月1日
//        dd(\Yii::$app->formatter->format('2014-01-01', 'time'));// 上午12:00:00
//        dd(\Yii::$app->formatter->format('2014-01-01', 'datetime'));// 2014年1月1日 上午12:00:00
        try {
            $this->verifyParam2($_REQUEST, array(
                // 检查 "selected" 是否为 0 或 1，无视数据类型
//                ['selected', 'boolean'],

                // 检查年龄是否大于等于 30
//                ['age', 'compare', 'compareValue' => 30, 'operator' => '>='],

//                [['age'], 'required'],
                // email 特性必须是一个有效的 email 地址

//                [['from_date', 'to_date'], 'date'],
//                [['from_datetime', 'to_datetime'], 'datetime'],
//                [['some_time'], 'time'],

                // 若 "country" 为空，则将其设为 "USA"
//                ['country', 'default', 'value' => 'USA'],

                // trim 掉 "username" 和 "email" 输入
//                [['username', 'email'], 'filter', 'filter' => 'trim'],

                // 检查 "ip_address" 是否为一个有效的 IPv4 或 IPv6 地址
//                ['ip_address', 'ip'],

                // 检查 "level" 是否为 1、2 或 3 中的一个
//                ['level', 'in', 'range' => [1, 2, 3]],

                // 检查 "age" 是否为整数
//                ['age', 'integer', 'min' => 1, 'max' => 2],

                // 检查 "username" 是否由字母开头，且只包含单词字符
//                ['username', 'match', 'pattern' => '/^[a-z]\w*$/i']

                // 检查 "salary" 是否为数字。他等效于 double 验证器
//                ['salary', 'number'],

                // 标记 "description" 为安全属性.该验证器并不进行数据验证。
//                ['description', 'safe'],

                // 检查 "username" 是否为长度 4 到 24 之间的字符串
                ['username', 'string', 'length' => [4, 24]],

                ['email', 'email'],
                ['username', 'string', 'length' => [4, 24]],
                ['age', 'integer', 'integerOnly' => true, 'min' => 10],
//                array('full_name', 'string', 'max' => 64),
//                array('gid', 'required'),
            ));
        } catch (\Exception $e) {
            $res = $e;
        }

        return $this->renderExeJson($res);
    }

    public function actionIndex2()
    {
//        dd(\Yii::$app->basePath);
//        dd(DATE_TIME);
//        dd(\Yii::getAlias('@bower'));
//        dd(\Yii::t('yii', 'Home'));
        return $this->renderJson('DB_ERROR', '', ['aa' => '[自定义]']);
    }

    public function actionIndex3()
    {
        try {
            $a = [];
            throw new \Exception('名称太长');
        } catch (\Exception $e) {
            $res = $e;
        }

//        $res = ['aaa'];
        return $this->renderExeJson($res);
    }
}
