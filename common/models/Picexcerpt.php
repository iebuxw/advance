<?php

namespace common\models;

use common\service\HcUploadFile;
use Yii;

/**
 * This is the model class for table "pic_excerpt".
 *
 * @property int $id
 * @property int $uid
 * @property string|null $url 图片
 * @property string|null $remark 备注
 * @property int $book_id 图书id
 * @property int|null $created_at 创建时间
 * @property int|null $updated_at 修改时间
 * @property string|null $tags 标签
 *
 * @property Book $book
 */
class Picexcerpt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pic_excerpt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['uid', 'book_id', 'created_at', 'updated_at'], 'integer'],
            [['remark', 'tags'], 'string'],// 注意rules需要加tags，否则修改不了
//            [['url'], 'string', 'max' => 255],
//            [['url'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
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
            'url' => Yii::t('app', '图片'),
            'remark' => Yii::t('app', '备注'),
            'tags' => Yii::t('app', '标签'),
            'book_id' => Yii::t('app', '图书id'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        list($ret, $file_name) = HcUploadFile::uploadFiles("Picexcerpt[url]");  //Artcile[thumb]存储的图片字段

        if($ret){
            $this->url= $file_name;
        } else {
            Yii::error($file_name);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // 编辑且传了图，则删除原图
        if (!$insert && isset($changedAttributes['url']) && $changedAttributes['url']) {
            delFile($changedAttributes['url']);// 删除文件
        }
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->url->saveAs('uploads/' . $this->url->baseName . '.' . $this->url->extension);
            return true;
        } else {
            return false;
        }
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

    public function getBeginning($len = 40)
    {
        $str = $this->remark;
        $tmp_len = mb_strlen($str);
        $str = mb_substr($str, 0, $len, 'utf-8');

        return $str . ($tmp_len > $len  ? '...' : '');
    }
}
