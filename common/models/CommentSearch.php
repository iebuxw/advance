<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form of `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    public function attributes()
    {
        return array_merge(parent::attributes(), ['username', 'title']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['content', 'email', 'url', 'username', 'title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 2],// 分页
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],// 默认排序
                'attributes' => ['id', 'title'],// 可排序字段，排序也可在这里加
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.status' => $this->status,
            'comment.create_time' => $this->create_time,
            'comment.userid' => $this->userid,
            'comment.post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'user', 'comment.userid = user.id');
        $query->andFilterWhere(['like', 'user.username', $this->username]);

        // 作者文章标题查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'post', 'comment.post_id = post.id');
        $query->andFilterWhere(['like', 'post.title', $this->title]);

        // 增加作者排序，排序也可在attributes里统一配置
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
