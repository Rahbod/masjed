<?php

namespace app\models;

use app\components\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SlideSearch represents the model behind the search form of `app\models\Slide`.
 */
class RequestSearch extends Request
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['name', 'email', 'mobile', 'phone', 'details'], 'string'],
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
        $query = Request::find();

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
            self::columnGetString('details') => $this->details,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['regexp', 'name', Helper::persian2Arabic($this->name)]);
        $query->andFilterWhere(['regexp', self::columnGetString('mobile'), $this->mobile]);
        $query->andFilterWhere(['regexp', self::columnGetString('phone'), $this->phone]);
        $query->andFilterWhere(['regexp', self::columnGetString('email'), $this->email]);

        $query->addOrderBy(['status' => SORT_ASC])
            ->addOrderBy(['id' => SORT_ASC]);

        return $dataProvider;
    }
}
