<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PicexcerptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', '图片摘录');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-excerpt-index">

    <!--    <h1><? //= Html::encode($this->title) ?>--><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'uid',
            [
                'attribute' => 'uname',
                'label'     => '用户名',
                'value'     => 'user.username',// 展示转换
            ],
//            'url:url',
//            'book_id',
            [
                'attribute' => 'bookname',
                'label'     => '书名',
                'value'     => 'book.name',// 展示转换
            ],
            [
                'label'  => '图片',
                "format" => 'raw',
                'value'  => function ($model) {
                    return Html::img($model->url, ["width" => "60", "height" => "60", "class" => 'index_list_img']);
                },
            ],
            'tags',
            'remark:ntext',
            [
                'label' => '创建时间',// 不让搜索
                'value' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
