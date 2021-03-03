<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px'],// 其它选项 - 固定宽度
            ],
            'username',
            'nickname',
//            'password',
            'email:email',
            //'profile:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {resetpwd} {privilege}',
                'buttons' => [
                    'resetpwd' => function($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', '重置密码'),
                            'aria-label' => Yii::t('yii', '重置密码'),
//                            'data-confirm' => Yii::t('yii', '你确定通过这条评论吗?'),
//                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, $options);
                    },
                    'privilege' => function($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', '权限'),
                            'aria-label' => Yii::t('yii', '权限'),
//                            'data-confirm' => Yii::t('yii', '你确定通过这条评论吗?'),
//                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
