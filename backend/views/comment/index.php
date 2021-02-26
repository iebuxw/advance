<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <?/*= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) */?>
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
            ['attribute' => 'content', 'value' => 'ShortContent'],
//            'content:ntext',
//            'status',
            [
                'attribute' => 'status',
                'value' => 'status0.name',// 展示转换
                'filter' => \common\models\CommentStatus::find()->select('name')->orderBy('id')->indexBy('id')->column(),//下拉筛选
                'contentOptions' => function($model){
                    return 1 == $model->status ? ['class' => 'bg-danger'] : [];
                }
            ],
//            'create_time:datetime',
// 日期格式化
            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'userid',
            [
                'attribute' => 'username',
                'label' => '作者',
                'value' => 'user.username',// 展示转换
            ],
            //'email:email',
            //'url:url',
            //'post_id',
            [
                'attribute' => 'title',
                'label' => '文章标题',
                'value' => 'post.title',// 展示转换
            ],

            // 加审核图标
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {approve}',
                'buttons' => [
                    'approve' => function($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', '审核'),
                            'aria-label' => Yii::t('yii', '审核'),
                            'data-confirm' => Yii::t('yii', '你确定通过这条评论吗?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
