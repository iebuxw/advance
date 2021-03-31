<?php

namespace frontend\controllers;

use frontend\components\MyBehavior;
use frontend\components\User;
use Yii;
use common\models\Book;
use common\models\BookSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    //	定义事件名字
    const EVENT_USER_LOGIN = 'user_login';

    public function __construct($id, $module, $config = [])
    {
        // ... 在应用配置之前初始化
        // 永远在你重写的构造方法结尾处调用一下父类的构造方法

        parent::__construct($id, $module, $config);
    }

    public function init()
    {
        parent::init();

        // ... 应用配置后进行初始化
        // 请确保你在 init 方法的开头处调用了父类的 init 方法
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        // other custom code here

        //绑定事件
        $this->on(self::EVENT_USER_LOGIN,['frontend\components\MyBehavior','add'], ['name' => '张三']);
        $this->on(self::EVENT_USER_LOGIN,['frontend\components\MyBehavior','send']);

        return true;// 要有这句，不然走不下去了
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        // your custom code here
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
                        'actions' => ['index', 'view', 'testbehav', 'testbehav3', 'testact'],
                        'allow' => true,
                        'roles' => ['?'],//?代表游客
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'testbehav'],
                        'allow' => true,
                        'roles' => ['@'],//@代表已认证用户
                    ],
                ],
            ],
        ];
    }

    //actions的作用主要是共用功能相同的方法
    public function actions()
    {
        return [
            // 这里如果测试，要把access行为注释掉，否则403
            'testact' => [
                'class' => 'frontend\components\TestAction',// 将这个方法映射过来
                'param1' => 'hello',
                'param2' => 'world',
                'param3' => '!!!',
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $params['BookSearch']['is_delete'] = \CommonConst::INACTIVE;

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        $model->uid = Yii::$app->user->identity->getId();
        $model->created_at = time();

        $params = $model->load(Yii::$app->request->post());

        if ($model->name && $model::findOne(['name' => $model->name, 'is_delete' => \CommonConst::INACTIVE])) {
            exit("<script>alert('书名重复');window.history.back(-1);</script>");
//            Yii::$app->session->setFlash('error', '书名重复');
//            return $this->goBack();
        }

        if ($params && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $uid = Yii::$app->user->identity->getId();

        $params = $model->load(Yii::$app->request->post());

        $book = $model::findOne(['name' => $model->name, 'is_delete' => \CommonConst::INACTIVE]);

        if ($book && $book->id != $id) {
            exit("<script>alert('书名重复');window.history.back(-1);</script>");
//            Yii::$app->session->setFlash('error', '书名重复');
//            return $this->goBack();
        }

        $model->updated_at = time();

        if ($model->uid == $uid && $params && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();
        $uid = Yii::$app->user->identity->getId();
        $model = $this->findModel($id);
        $model->is_delete = \CommonConst::ACTIVE;
        $model->uid == $uid && $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    // 测试行为，注意别写成了actionTestBehav，仅仅testbehav定位不到
    // 可以注入的方式扩展组件的属性和方法
    public function actionTestbehav()
    {
        $user = new User();
        //$user对像附加行为，扩充功能
        $user->attachBehavior('myBehavior', new MyBehavior());

        $user->prop1 = 1;
        var_dump($user->prop1);

        // 使用方法foo
        var_dump($user->foo());

        exit();
    }

    // 测试行为，注意别写成了actionTestBehav，仅仅testbehav定位不到
    // 可以注入的方式扩展组件的属性和方法
    public function actionTestbehav2()
    {
        $user = new User();
        //$user对像附加行为，扩充功能
        $user->attachBehavior('myBehavior', new MyBehavior());

        $user->prop1 = 1;
        var_dump($user->prop1);

        // 使用方法foo
        var_dump($user->foo());

        exit();
    }

    // 测试自定义事件
    public function actionTestbehav3()
    {
        $this->trigger(self::EVENT_USER_LOGIN);
        exit();
    }

    public function booktesstAction()
    {
        exit('测试独立动作，控制器重用， 或重构为扩展。');
    }
}
