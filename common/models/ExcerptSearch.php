<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Excerpt;

/**
 * ExcerptSearch represents the model behind the search form of `common\models\Excerpt`.
 */
class ExcerptSearch extends Excerpt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'page', 'book_id', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['content', 'chapter', 'tags', 'idea', 'uname', 'bookname'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['uname', 'bookname']);
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
        $query = Excerpt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => PAGE_SIZE],// 分页
            'sort' => [
                'defaultOrder' => ['excerpt.id' => SORT_DESC],// 默认排序
                'attributes' => ['excerpt.id'],// 可排序字段
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'page' => $this->page,
            'book_id' => $this->book_id,
            'excerpt.is_delete' => $this->is_delete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'user', 'excerpt.uid = user.id');
        $query->andFilterWhere(['like', 'user.username', $this->uname]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'book', 'excerpt.book_id = book.id');
        $query->andFilterWhere(['like', 'book.name', $this->bookname]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'idea', $this->idea]);

        return $dataProvider;
    }
}