<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use common\models\AuthAssignment;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'money', 'gold', 'premium', 'command', 'referal', 'rate'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'phone', 'fights', 'victories', 'looses'], 'safe'],
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
		
        $query = User::find();

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
		
		if(isset($params['admin']) && $params['admin'] == 1){
			$ids = AuthAssignment::find()->where(['item_name'=>'admin'])->all();
			foreach($ids as $key=>$value){
				$algor[] = $value->user_id;
			}
		} else {
			$ids = AuthAssignment::find()->where(['item_name'=>'admin'])->all();
			foreach($ids as $key=>$value){
				$algor[] = $value->user_id;
			}
			$uses = User::find()->where(['not in','id',$algor])->all();
			$algor = [];
			foreach($uses as $key=>$value){
				$algor[] = $value->id;
			}
		}
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $algor,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'money' => $this->money,
            'gold' => $this->gold,
            'premium' => $this->premium,
            'command' => $this->command,
            'referal' => $this->referal,
            'rate' => $this->rate,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fights', $this->fights])
            ->andFilterWhere(['like', 'victories', $this->victories])
            ->andFilterWhere(['like', 'looses', $this->looses]);

        return $dataProvider;
    }
}
