<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        // 过滤器：过滤器是 控制器动作 执行之前或之后执行的对象，过滤器本质上是一类特殊的 行为
        // ACF是一种通过yii\filters\AccessControl类来实现的简单授权，有两种角色 ？：未经认证的游客用户 @：已认证的用户
        // verbs限制请求方式
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['login', 'logout', 'signup'],// 只对某些动作起作用，only 中没有列出的动作，将无条件获得授权
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?'],//?代表游客
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],//@代表已认证用户
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        直接sql
//        $post = Yii::$app->db->createCommand('select * from post')->queryOne();

//        使用query
//        ->limit(1)->one() 建议加limit(1)来改善性能

        $post = (new \yii\db\Query())
            ->select(['title'])
            ->from('post')
//            ->where(['<>', 'status', 3])
            ->limit(2)
            ->indexBy('id')
            ->column();
//        dd($post);
//        使用ar，AtiveRecord 是继承自Model的。findOne、findAll、findBySql
//        Post::find  ===>  又回到query了
//        $post = Post::findOne($id)->toArray();
//        $post = Post::findAll([]);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createPost')) {
            throw new ForbiddenHttpException(' 对不起，你没有进行该操作的权限。');
        }

        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updatePost')) {
            throw new ForbiddenHttpException(' 对不起，你没有进行该操作的权限。');
        }

        $model = $this->findModel($id);

        // save方法的流程：验证前、验证、验证后、保存前、保存、保存后
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deletePost')) {
            throw new ForbiddenHttpException(' 对不起，你没有进行该操作的权限。');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
