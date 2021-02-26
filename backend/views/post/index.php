<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'], //序列号

//            'id',
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px'],// 其它选项 - 固定宽度
            ],
            'title',
//            'content:ntext',
            'tags:ntext',
//            'status',
            [
                'attribute' => 'status',
                'value' => 'status0.name',// 展示转换
                'filter' => \common\models\PostStatus::find()->select('name')->orderBy('id')->indexBy('id')->column(),//下拉筛选
            ],
            //'create_time:datetime',
            //'update_time:datetime',

            // 日期格式化
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            //'author_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
