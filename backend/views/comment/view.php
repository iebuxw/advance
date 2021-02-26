<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除本评论吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'content:ntext',
//            'status',
            [
                'attribute' => 'status',
                'value' => $model->status0->name,// 展示转换
            ],
            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'username',
                'label' => '作者',
                'value' => $model->user->username,// 展示转换
            ],
            'email:email',
            'url:url',
//            'post_id',
            [
                'attribute' => 'title',
                'label' => '文章标题',
                'value' => $model->post->title,// 展示转换
            ]
        ],
    ]) ?>

</div>
