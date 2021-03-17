<?php

namespace app\modules\admin\controllers;

use backend\controllers\BaseController;
use common\models\Post;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class TestABCController extends BaseController
{
    public function actionIndex()
    {
        echo 'cMap';
        exit();
    }
}
