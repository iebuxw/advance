<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content 内容
 * @property int $status 状态
 * @property int|null $create_time 创建时间
 * @property int $userid
 * @property string $email 邮箱
 * @property string|null $url 网址
 * @property int $post_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['id', 'status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['content'], 'string'],
            [['email', 'url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '创建时间',
            'userid' => 'Userid',
            'email' => '邮箱',
            'url' => '网址',
            'post_id' => 'Post ID',
        ];
    }

    // 获取状态名称，status0与本表的status避免冲突
    // $model->status0 会访问到这里，原因是AR继承了BaseObject，而BaseObject里有__set和__get
    // 这就是属性概念
    public function getStatus0()
    {
        return $this->hasOne(CommentStatus::className(), ['id' => 'status']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public static function getPeddingCommentCount()
    {
        return self::find()->where(['status' => 1])->count();
    }

    // 评论内容截取，属性转化
    public function getShortContent()
    {
        return mb_strlen($this->content) > 10 ? mb_substr($this->content, 0, 10, 'utf-8') . '...' : $this->content;
    }
}
