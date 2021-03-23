<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Excerpt */

$this->title = Yii::t('app', '修改: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '摘录'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="excerpt-update">

<!--    <h1><?//= Html::encode($this->title) ?>--><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
