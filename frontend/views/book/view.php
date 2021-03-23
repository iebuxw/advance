<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '图书'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'name',
            'author',
            'intro:ntext',
//            'is_delete',
//            'created_at',
            ['attribute' => 'created_at', 'value' => date('Y-m-d H:i:s', $model->created_at)],
//            'updated_at',
            ['attribute' => 'updated_at', 'value' => $model->updated_at?date('Y-m-d H:i:s', $model->updated_at):'-'],
        ],
    ]) ?>

</div>
