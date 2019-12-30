<?php

namespace app\models;


use app\components\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ListsSearch extends Lists
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parentID', 'slug', 'status', 'left', 'right', 'depth', 'tree'], 'integer'],
            [['type', 'name', 'dyna', 'extra', 'menu_type'], 'safe'],
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
        $query = Lists::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => $this->status,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['REGEXP', 'name', Helper::persian2Arabic($this->name)]);

        if ($this->parentID)
            $query->andFilterWhere(['parentID' => $this->parentID]);
        else
            $query->andWhere(['is', 'parentID', null]);

        $query->orderBy([self::columnGetString('sort') => SORT_ASC]);


        $dataProvider->pagination = false;
        return $dataProvider;
    }
}
