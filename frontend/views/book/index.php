<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '图书');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <p>
        <?= Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'uid',
            'name',
            'author',
//            'intro:ntext',
            [
                'attribute' => 'intro',
                'label' => '简介',
                'value' => 'beginning',// 展示转换
            ],
            //'is_delete',
            [
                'label' => '创建时间',// 不让搜索
                'value' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
