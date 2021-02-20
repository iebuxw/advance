<?php

namespace common\models;

use Yii;

/**
 * common是前后台公用，post模型放在common里
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $content 内容
 * @property string|null $tags 标签
 * @property int $status 状态
 * @property int|null $create_time 创建时间
 * @property int|null $update_time
 * @property int $author_id
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'content', 'status', 'author_id'], 'required'],
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['content', 'tags'], 'string'],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
        ];
    }
}
