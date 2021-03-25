<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Excerpt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="excerpt-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    <?//= $form->field($model, 'uid')->textInput() ?>-->
    <?= $form->field($model, 'book_id')->dropDownList((new \common\models\Book())->bookNames, ['prompt' => '--请选择--']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => '多个用英文逗号分隔']) ?>

    <?= $form->field($model, 'idea')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'page')->textInput() ?>

    <?= $form->field($model, 'chapter')->textInput(['maxlength' => true]) ?>

<!--    <?//= $form->field($model, 'book_id')->textInput() ?>-->

<!--    <?//= $form->field($model, 'is_delete')->textInput() ?>-->

<!--    <?//= $form->field($model, 'created_at')->textInput() ?>-->

<!--    <?//= $form->field($model, 'updated_at')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
