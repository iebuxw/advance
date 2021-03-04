<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags', 'author_name'], 'safe'],//@todo 问：author_name为什么要加在这里？
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['author_name']);
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 2],// 分页
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],// 默认排序
                'attributes' => ['id', 'title'],// 可排序字段
            ],
        ]);

        $this->load($params);// 前台提交参数类似：PostSearch[id]、PostSearch[title]，可以使用load

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');// 不返回数据
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'adminuser', 'post.author_id = adminuser.id');
        $query->andFilterWhere(['like', 'adminuser.nickname', $this->author_name]);

        // 增加作者排序
        $dataProvider->sort->attributes['author_name'] = [
            'asc' => ['adminuser.nickname' => SORT_ASC],
            'desc' => ['adminuser.nickname' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
