<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Compilation;

/**
 * CompilationSearch represents the model behind the search form of `common\models\Compilation`.
 */
class CompilationSearch extends Compilation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'picture', 'description', 'audio', 'buttontext', 'metatitle', 'metadescription', 'metakeywords'], 'safe'],
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
        $query = Compilation::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'audio', $this->audio])
            ->andFilterWhere(['like', 'buttontext', $this->buttontext])
            ->andFilterWhere(['like', 'metatitle', $this->metatitle])
            ->andFilterWhere(['like', 'metadescription', $this->metadescription])
            ->andFilterWhere(['like', 'metakeywords', $this->metakeywords]);

        return $dataProvider;
    }
}
