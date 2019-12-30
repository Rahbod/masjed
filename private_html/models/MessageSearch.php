<?php

namespace app\models;

use app\components\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;

/**
 * MessageSearch represents the model behind the search form of `app\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'type', 'tel', 'body', 'dyna', 'created', 'department_id'], 'safe'],
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
        $query = Message::find();

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
            'id' => $this->id,
            'type' => $this->type,
            self::columnGetString('department_id') => $this->department_id,
        ]);

        $query->andFilterWhere(['regexp', 'name', Helper::persian2Arabic($this->name)]);
        $query->andFilterWhere(['regexp', 'tel', $this->tel]);
        $query->andFilterWhere(['regexp', self::columnGetString('subject'), $this->subject]);
        $query->andFilterWhere(['regexp', self::columnGetString('email'), $this->email]);

        $query->addOrderBy(['type' => SORT_ASC])
            ->addOrderBy(['id' => SORT_ASC]);

        return $dataProvider;
    }
}
