<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Excerpt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '摘录'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="excerpt-view">

<!--    <h1><?//= Html::encode($this->title) ?>--><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '您确定要删除此项吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'uid',
            ['attribute' => '用户名', 'value' => $model->user->username],
            'content:ntext',
            'page',
            'chapter',
            'tags',
            'idea:ntext',
//            'book_id',
            ['attribute' => '书名', 'value' => $model->book->name],
//            'is_delete',
            ['attribute' => 'created_at', 'value' => date('Y-m-d H:i:s', $model->created_at)],
//            'updated_at',
            ['attribute' => 'updated_at', 'value' => $model->updated_at?date('Y-m-d H:i:s', $model->updated_at):'-'],
        ],
    ]) ?>

</div>
