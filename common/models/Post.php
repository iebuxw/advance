<?php

namespace common\models;

use phpDocumentor\Reflection\DocBlock\Tag;
use Yii;
use yii\helpers\Html;

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
            'update_time' => '更新时间',
            'author_id' => '作者',
        ];
    }

    // 获取状态名称，status0与本表的status避免冲突
    public function getStatus0()
    {
        return $this->hasOne(PostStatus::className(), ['id' => 'status']);
    }

    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }

    // 更新文章自动加更新时间
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
            } else {
                $this->update_time = time();
            }

            return true;
        } else {
            return false;
        }
    }

    // aftersave 里面不要放业务逻辑,代码多了或者人不靠谱了，调试起来会很费劲。基本上用调用来发个消息啊更新个缓存啊之类的失败也没太大关系的那种逻辑
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
//@todo        疑问：为什么id没有改变但也会记录到$changedAttributes
//        Yii::error($changedAttributes);
    }

    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(['post/detail', 'id' => $this->id, 'title' => $this->title]);
    }

    public function getBeginning($len = 228)
    {
        $str = strip_tags($this->content);
        $tmp_len = mb_strlen($str);
        $str = mb_substr($str, 0, $len, 'utf-8');

        return $str . ($tmp_len > $len  ? '...' : '');
    }

    public function getTagLinks()
    {
        $links = [];
        $tags = ['文学', '历史'];
        foreach ($tags as $tag) {
            $links[] = Html::a(Html::encode($tag), ['post/index', 'PostFrontSearch[tags]' => $tag]);
        }

        return $links;
    }

    public function getCommentCount()
    {
        return Comment::find()->where(['post_id' => $this->id, 'status' => 2])->count();
    }
}
