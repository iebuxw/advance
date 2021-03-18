<?php

namespace app\modules\admin\controllers;

use backend\controllers\BaseController;
use common\models\Post;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
//        dd(\Yii::$app->formatter->format('2014-01-01', 'date'));// 2014年1月1日
//        dd(\Yii::$app->formatter->format('2014-01-01', 'time'));// 上午12:00:00
//        dd(\Yii::$app->formatter->format('2014-01-01', 'datetime'));// 2014年1月1日 上午12:00:00
        try {
            $this->verifyParam2($_REQUEST, array(
                // 检查 "selected" 是否为 0 或 1，无视数据类型
//                ['selected', 'boolean'],

                // 检查年龄是否大于等于 30
//                ['age', 'compare', 'compareValue' => 30, 'operator' => '>='],

//                [['age'], 'required'],
                // email 特性必须是一个有效的 email 地址

//                [['from_date', 'to_date'], 'date'],
//                [['from_datetime', 'to_datetime'], 'datetime'],
//                [['some_time'], 'time'],

                // 若 "country" 为空，则将其设为 "USA"
//                ['country', 'default', 'value' => 'USA'],

                // trim 掉 "username" 和 "email" 输入
//                [['username', 'email'], 'filter', 'filter' => 'trim'],

                // 检查 "ip_address" 是否为一个有效的 IPv4 或 IPv6 地址
//                ['ip_address', 'ip'],

                // 检查 "level" 是否为 1、2 或 3 中的一个
//                ['level', 'in', 'range' => [1, 2, 3]],

                // 检查 "age" 是否为整数
//                ['age', 'integer', 'min' => 1, 'max' => 2],

                // 检查 "username" 是否由字母开头，且只包含单词字符
//                ['username', 'match', 'pattern' => '/^[a-z]\w*$/i']

                // 检查 "salary" 是否为数字。他等效于 double 验证器
//                ['salary', 'number'],

                // 标记 "description" 为安全属性.该验证器并不进行数据验证。
//                ['description', 'safe'],

                // 检查 "username" 是否为长度 4 到 24 之间的字符串
                ['username', 'string', 'length' => [4, 24]],

                ['email', 'email'],
                ['username', 'string', 'length' => [4, 24]],
                ['age', 'integer', 'integerOnly' => true, 'min' => 10],
//                array('full_name', 'string', 'max' => 64),
//                array('gid', 'required'),
            ));
        } catch (\Exception $e) {
            $res = $e;
        }

        return $this->renderExeJson($res);
    }

    public function actionIndex2()
    {
//        dd(\Yii::$app->basePath);
//        dd(DATE_TIME);
//        dd(\Yii::getAlias('@bower'));
//        dd(\Yii::t('yii', 'Home'));
        return $this->renderJson('DB_ERROR', '', ['aa' => '[自定义]']);
    }

    public function actionIndex3()
    {
        try {
            $a = [];
            throw new \Exception('名称太长');
        } catch (\Exception $e) {
            $res = $e;
        }

//        $res = ['aaa'];
        return $this->renderExeJson($res);
    }

    // ar 操作
    public function actionIndex4()
    {
//        3步走
//        通过 yii\db\ActiveRecord::find() 方法创建一个新的查询生成器对象；
//        使用查询生成器的构建方法来构建你的查询；
//        调用查询生成器的查询方法来取出数据到 Active Record 实例中。
        $customer = Post::find()->where(['id' => 32])->one()->toArray();
        $customer = Post::find()->where(['id' => 32])->all();
        $customer = Post::find()->where(['id' => 32])->count();

        // findOne 和 findAll
        $customer = Post::findOne(32)->toArray();
        $customers = Post::findAll([32, 33, 123, 124]);

        // 返回全部
        $customers = Post::find()->asArray()->all();

        // 批量
        // 每次获取 10 条客户数据，然后一条一条迭代它们
//        foreach (Post::find()->each(10) as $post) {
            // $customer 是个 `Customer` 对象
//            print_r($post);
//        }

        // 保存，并且保存会进行验证，如果数据可信，则$post->save(false);即可
//        $post = new Post();
//        $post->title = 'James';
//        $r = $post->save();
//        dd($post->errors);
//        dd($customers);

        //  事物，会抛异常
//        $post = Post::findOne(123);
//        Post::getDb()->transaction(function($db) use ($post) {
//            $post->id = 200;
//            $post->save();
//             ...其他 DB 操作...
//        });
    }

    // where
    public function actionIndex5()
    {
        $username = 1;
        // 3种格式
//        字符串格式，例如：'status=1' // 最好换成参数绑定的形式，$query->where('status=:status', [':status' => $status]);
//          哈希格式，例如： ['status' => 1, 'type' => [2,4]]       // 等于条件
//          操作符格式，例如：// 任意条件语句
//          ['like', 'name', 'test']
//          ['!=', 'id', 32]
//          ['>', 'age', 10]
//        ['between', 'id', 1, 10]
        $customer = Post::find()
            ->select(['id'])// 指定字段
            ->where(['!=', 'id', 32])
            ->andFilterWhere(['username' => $username])
            ->andFilterCompare('value', '<=100')
            ->orderBy(['id' => SORT_ASC, 'name' => SORT_DESC,])
            ->groupBy(['id', 'status'])
            ->limit(10)
            ->offset(20)
            ->join('LEFT JOIN', 'post', 'post.user_id = user.id')
            ->asArray()
            ->exists();// all、one、column、scalar、exists、count

        // 注意asArray和toArray

//        filterWhere() 和 where() 唯一的不同就在于，前者 将忽略空值(空字符串\空白\null\[])

        //  追加条件 andWhere() 和 orWhere()， 你可以使用 andFilterWhere() 和 orFilterWhere()、andFilterCompare()
//        andFilterCompare会智能地确定运算符：(<>|>=|>|<=|<|=)
//        $query->andFilterCompare('value', '<=100');
//        $query->andFilterCompare('name', 'John Doe');
    }

    public function actionIndex6()
    {
        // 增删改
//        save、updateAll、insert、update、updateCounters
//        deleteAll
        try {
            $this->verifyParam2($_REQUEST, array(
                // 检查 "selected" 是否为 0 或 1，无视数据类型
//                ['selected', 'boolean'],

                // 检查年龄是否大于等于 30
//                ['age', 'compare', 'compareValue' => 30, 'operator' => '>='],

//                [['age'], 'required'],
                // email 特性必须是一个有效的 email 地址

//                [['from_date', 'to_date'], 'date'],
//                [['from_datetime', 'to_datetime'], 'datetime'],
//                [['some_time'], 'time'],

                // 若 "country" 为空，则将其设为 "USA"
//                ['country', 'default', 'value' => 'USA'],

                // trim 掉 "username" 和 "email" 输入
//                [['username', 'email'], 'filter', 'filter' => 'trim'],

                // 检查 "ip_address" 是否为一个有效的 IPv4 或 IPv6 地址
//                ['ip_address', 'ip'],

                // 检查 "level" 是否为 1、2 或 3 中的一个
//                ['level', 'in', 'range' => [1, 2, 3]],

                // 检查 "age" 是否为整数
//                ['age', 'integer', 'min' => 1, 'max' => 2],

                // 检查 "username" 是否由字母开头，且只包含单词字符
//                ['username', 'match', 'pattern' => '/^[a-z]\w*$/i']

                // 检查 "salary" 是否为数字。他等效于 double 验证器
//                ['salary', 'number'],

                // 标记 "description" 为安全属性.该验证器并不进行数据验证。
//                ['description', 'safe'],

                // 检查 "username" 是否为长度 4 到 24 之间的字符串
                ['username', 'string', 'length' => [4, 24]],
                array('username', 'required'),
                ['email', 'email'],
                ['username', 'string', 'length' => [4, 24]],
                ['age', 'integer', 'integerOnly' => true, 'min' => 10],
//                array('full_name', 'string', 'max' => 64),
//                array('gid', 'required'),
            ));
        } catch (\Exception $e) {
            $this->resp = $e;
        }

        return $this->renderExeJson();
    }

    public function actionIndex7()
    {
        // 获取值
        $array = [];
        ArrayHelper::getValue($array, 'foo.bar.name', '默认值');
        // 回调函数获取值
        $fullName = ArrayHelper::getValue($array, function ($user, $defaultValue) {
            return $user->firstName . ' ' . $user->lastName;
        });

        // 设定值
        ArrayHelper::setValue($array, 'key.in', ['arr' => 'val']);

        // 删除值，用得不多

        // 检查键名的存在
        // ArrayHelper::keyExists

        // 获取列
        $data = [
            ['id' => '123', 'data' => 'abc'],
            ['id' => '345', 'data' => 'def'],
        ];
        $ids = ArrayHelper::getColumn($data, 'id');

        // 重建索引
        $array = [
            ['id' => '123', 'data' => 'abc', 'device' => 'laptop'],
            ['id' => '345', 'data' => 'def', 'device' => 'tablet'],
            ['id' => '345', 'data' => 'hgi', 'device' => 'smartphone'],
        ];
        $result = ArrayHelper::index($array, 'id');

        // 建立哈希表
        $array = [
            ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
            ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
            ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
        ];

        $result = ArrayHelper::map($array, 'id', 'name');
        $result = ArrayHelper::map($array, 'id', 'name', 'class');// 分组

        // 多维排序
        $data = [
            ['age' => 30, 'name' => 'Alexander'],
            ['age' => 30, 'name' => 'Brian'],
            ['age' => 19, 'name' => 'Barney'],
        ];
        ArrayHelper::multisort($data, ['age', 'name'], [SORT_ASC, SORT_DESC]);

        // 数组合并
        $array1 = [
            'name' => 'Yii',
            'version' => '1.1',
            'ids' => [
                1,
                1,
                'name' => 111111,
            ],
            'validDomains' => [
                'example.com',
                'www.example.com',
            ],
            'emails' => [
                'admin' => 'admin@example.com',
                'dev' => 'dev@example.com',
            ],
        ];

        $array2 = [
            'version' => '2.0',
            'ids' => [
                2,// 会合并
                'name' => 33333333,// 会覆盖
            ],
            'validDomains' => new \yii\helpers\ReplaceArrayValue([// 替换
                'yiiframework.com',
                'www.yiiframework.com',
            ]),
            'emails' => [
                'dev' => new \yii\helpers\UnsetArrayValue(),// 删除
            ],
        ];

        $result = ArrayHelper::merge($array1, $array2);
        dd($result);
    }
}
