<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ExcerptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '摘抄');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excerpt-index">

    <p>
        <?= Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'uid',
            [
                'attribute' => 'uname',
                'label' => '会员',
                'value' => 'user.username',// 展示转换
            ],
            [
                'attribute' => 'bookname',
                'label' => '书名',
                'value' => 'book.name',// 展示转换
            ],
//            'content',
            [
                'attribute' => 'content',
                'label' => '内容',
                'value' => 'memo',// 展示转换
            ],
//            'page',
//            'chapter',
            'tags',
            //'idea:ntext',
            //'book_id',
            //'is_delete',
            //'created_at',
            [
                'label' => '创建时间',// 不让搜索
                'value' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
