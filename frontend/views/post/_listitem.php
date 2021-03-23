<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-listitem">

    <div class="title">
        <h2><a href="<?= $model->url; ?>"><?= Html::encode($model->title); ?></a></h2>
        <div class="author">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span><em><?= date('Y-m-d H:i:s', $model->create_time); ?></em>&nbsp;&nbsp;
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span><em><?= Html::encode($model->author_id); ?></em>
        </div>
    </div>

    <div class="content">
        <?= $model->beginning; ?>
    </div>
    <br>
    <div class="content">
        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
        <?= implode(', ', $model->tagLinks); ?>
        <br>
        <?= Html::a('评论 (' . $model->commentCount . ')', $model->url . '#comments'); ?> | 最后修改于<?= date('Y-m-d H:i:s', $model->update_time); ?>
    </div>
</div>
