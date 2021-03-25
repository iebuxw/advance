<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Picexcerpt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pic-excerpt-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<!--    <?//= $form->field($model, 'uid')->textInput() ?>-->

    <?= $form->field($model, 'book_id')->dropDownList((new \common\models\Book())->bookNames, ['prompt' => '请选择']) ?>

<!--    <?//= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

<!--    <?//= $form->field($model, 'book_id')->textInput() ?>-->

        <?= $form->field($model, 'url')->fileInput() ?>

<!--    <?//= $form->field($model, 'created_at')->textInput() ?>-->

<!--    <?//= $form->field($model, 'updated_at')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
