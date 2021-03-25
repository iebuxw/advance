<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discuss".
 *
 * @property int $id
 * @property int $uid
 * @property int $data_id 摘录id
 * @property string|null $content 内容
 * @property int|null $is_delete 删除
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 修改时间
 *
 * @property User $user
 * @property PicExcerpt $data
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
            [['uid', 'data_id'], 'required'],
            [['uid', 'data_id', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            [['data_id'], 'exist', 'skipOnError' => true, 'targetClass' => PicExcerpt::className(), 'targetAttribute' => ['data_id' => 'id']],
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
            'data_id' => Yii::t('app', '摘录id'),
            'content' => Yii::t('app', '内容'),
            'is_delete' => Yii::t('app', '删除'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * Gets query for [[Data]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getData()
    {
        return $this->hasOne(PicExcerpt::className(), ['id' => 'data_id']);
    }

    public static function getRecentDis($limit = 100)
    {
        return self::find()->where(['is_delete' => \CommonConst::INACTIVE])->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }
}
