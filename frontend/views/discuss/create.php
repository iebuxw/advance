<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Discuss */

$this->title = Yii::t('app', 'Create Discuss');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discusses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discuss-create">

<!--    <h1><?//= Html::encode($this->title) ?>--><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
