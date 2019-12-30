<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProjectSearch represents the model behind the search form of `app\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['type'], 'number'],
            [['name', 'en_name', 'ar_name', 'subtitle', 'ar_subtitle', 'en_subtitle'], 'safe'],
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
        $query = Project::find();

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

        if(($lang = app()->language) == 'fa') {
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->orFilterWhere(['like', self::columnGetString('subtitle'), $this->subtitle]);
        }else {
            $query->andFilterWhere(['like', self::columnGetString($lang . '_name'), $this->name]);
            $query->orFilterWhere(['like', self::columnGetString($lang . '_subtitle'), $this->subtitle]);
        }

        $query->addOrderBy([self::columnGetString('special') => SORT_DESC])
            ->addOrderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
