<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
<!--    <h1><?//= Html::encode($this->title) ?>--><!--</h1>-->

<!--    <p>Please fill out the following fields to login:</p>-->

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('用户名') ?>

                <div style="color:#999;margin:1em 0">
                    如果你忘了密码，你可以 <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    需要新的验证电子邮件? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
