<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment_status".
 *
 * @property int $id 状态id
 * @property string|null $name 状态名称
 */
class CommentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    public static function getNameMap()
    {
        return self::find()->select('name')->indexBy('id')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '状态id',
            'name' => '状态名称',
        ];
    }
}
