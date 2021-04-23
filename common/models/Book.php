<?php

namespace common\models;

use frontend\components\MyBehavior2;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int $uid
 * @property string $name 书名
 * @property string $author 作者
 * @property string|null $intro 简介
 * @property int|null $is_delete 删除
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 修改时间
 *
 * @property Excerpt[] $excerpts
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    public function behaviors()
    {
        return [
//            TimestampBehavior::className(),// 给created_at和updated_at自动赋值
            MyBehavior2::className()//行为的静态附加
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'author'], 'required'],
            [['uid', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['intro'], 'string'],
            [['name', 'author'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', '书名'),
            'author' => Yii::t('app', '作者'),
            'intro' => Yii::t('app', '简介'),
            'is_delete' => Yii::t('app', '删除'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /**
     * Gets query for [[Excerpts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExcerpts()
    {
        return $this->hasMany(Excerpt::className(), ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Excerpts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPicExcerpts()
    {
        return $this->hasMany(Picexcerpt::className(), ['book_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getBookNames()
    {
        return self::find()->select('name')->indexBy('id')->orderBy(['id' => SORT_DESC])->where(['is_delete' => \CommonConst::INACTIVE])->column();
    }

    public function getBeginning($len = 30)
    {
        $str = strip_tags($this->intro);
        $tmp_len = mb_strlen($str);
        $str = mb_substr($str, 0, $len, 'utf-8');

        return $str . ($tmp_len > $len  ? '...' : '');
    }
}
