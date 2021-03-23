<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "excerpt".
 *
 * @property int $id
 * @property int $uid
 * @property string $content 内容
 * @property int|null $page 页码
 * @property string|null $chapter 章节
 * @property string|null $tags 标签
 * @property string|null $idea 感悟
 * @property int $book_id 图书id
 * @property int|null $is_delete 删除
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 修改时间
 *
 * @property Discuss[] $discusses
 * @property Book $book
 */
class Excerpt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'excerpt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'content', 'book_id'], 'required'],
            [['uid', 'page', 'book_id', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['idea'], 'string'],
            [['chapter', 'tags'], 'string', 'max' => 255],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
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
            'content' => Yii::t('app', '内容'),
            'page' => Yii::t('app', '页码'),
            'chapter' => Yii::t('app', '章节'),
            'tags' => Yii::t('app', '标签'),
            'idea' => Yii::t('app', '感悟'),
            'book_id' => Yii::t('app', '图书id'),
            'is_delete' => Yii::t('app', '删除'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /**
     * Gets query for [[Discusses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiscusses()
    {
        return $this->hasMany(Discuss::className(), ['excerpt_id' => 'id']);
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
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

    public function getMemo($len = 30)
    {
        $str = strip_tags($this->content);
        $tmp_len = mb_strlen($str);
        $str = mb_substr($str, 0, $len, 'utf-8');

        return $str . ($tmp_len > $len  ? '...' : '');
    }
}
