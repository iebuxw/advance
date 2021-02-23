<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_status".
 *
 * @property int $id 状态id
 * @property string|null $name 状态名称
 */
class PostStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_status';
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
