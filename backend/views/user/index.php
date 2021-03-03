<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <?/*= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

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
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
//            'status',
            [
                'attribute' => 'status',
                'value' => 'statusName',// 展示转换
                'filter' => \common\models\User::$statusNames,//下拉筛选
            ],
//            'created_at',
//            'updated_at',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            //'verification_token',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>


</div>
