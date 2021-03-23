<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discuss".
 *
 * @property int $id
 * @property int $uid
 * @property int $excerpt_id 摘录id
 * @property string|null $content 内容
 * @property int|null $is_delete 删除
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 修改时间
 *
 * @property Excerpt $excerpt
 */
class Discuss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discuss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'excerpt_id'], 'required'],
            [['uid', 'excerpt_id', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['excerpt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Excerpt::className(), 'targetAttribute' => ['excerpt_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'excerpt_id' => Yii::t('app', '摘录id'),
            'content' => Yii::t('app', '内容'),
            'is_delete' => Yii::t('app', '删除'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /**
     * Gets query for [[Excerpt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExcerpt()
    {
        return $this->hasOne(Excerpt::className(), ['id' => 'excerpt_id']);
    }
}
