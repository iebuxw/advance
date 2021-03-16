<?php
namespace backend\models;

use yii\base\Model;

/**
 * Class SimpleModel
 * @package backend\models
 */
class SimpleModel extends Model
{
    private static $_names=array();
    public $_rules      = array();
    public  $_attributes = array();

    public function __get($name)
    {
        return $this->_attributes[$name];
    }

    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    public function setRules($rules)
    {
        $this->_rules = $rules;
    }

    public function rules()
    {
        return $this->_rules;
    }

    public function attributeLabels()
    {
        // 验证字段转中文
        return \CommonConst::$fieldName;
    }
}