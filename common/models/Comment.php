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
}
