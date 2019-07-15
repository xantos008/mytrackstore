<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tournament as TournamentModel;

/**
 * Tournament represents the model behind the search form about `common\models\Tournament`.
 */
class Tournament extends TournamentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'members', 'position'], 'integer'],
            [['name', 'datestart', 'dateend', 'maps', 'type', 'type_money', 'fon', 'startmoney', 'pricefond'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = TournamentModel::find();

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
            'status' => $this->status,
            'datestart' => $this->datestart,
            'dateend' => $this->dateend,
            'pricefond' => $this->pricefond,
            'members' => $this->members,
            'type' => $this->type,
            'type_money' => $this->type_money,
            'fon' => $this->fon,
            'position' => $this->position,
            'startmoney' => $this->startmoney,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'maps', $this->maps]);

        return $dataProvider;
    }
}
