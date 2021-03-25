<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Picexcerpt;

/**
 * PicExcerptSearch represents the model behind the search form of `common\models\PicExcerpt`.
 */
class PicexcerptSearch extends Picexcerpt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'book_id', 'created_at', 'updated_at'], 'integer'],
            [['url', 'remark', 'tags', 'uname', 'bookname'], 'safe'],
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
        $query = Picexcerpt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => PAGE_SIZE],// 分页
            'sort' => [
                'defaultOrder' => ['pic_excerpt.id' => SORT_DESC],// 默认排序
                'attributes' => ['pic_excerpt.id'],// 可排序字段
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
            'book_id' => $this->book_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'user', 'pic_excerpt.uid = user.id');
        $query->andFilterWhere(['like', 'user.username', $this->uname]);

        // 作者姓名查询，andFilterWhere方法有一个好处：如果条件为(空字符串、空白、null、空数组)会自动忽略
        $query->join('INNER JOIN', 'book', 'pic_excerpt.book_id = book.id');
        $query->andFilterWhere(['like', 'book.name', $this->bookname]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        return $dataProvider;
    }
}
