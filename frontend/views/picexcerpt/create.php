<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Picexcerpt */

$this->title = Yii::t('app', '新增');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '图片摘录'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-excerpt-create">

<!--    <h1><?//= Html::encode($this->title) ?>--><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
