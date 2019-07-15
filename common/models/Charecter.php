<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "charecter".
 *
 * @property integer $char_id
 * @property integer $account_id
 * @property string $PlayerName
 * @property integer $MaxHP
 * @property integer $IdCharMesh
 * @property integer $PlayerScores
 * @property integer $scene_ID
 * @property double $x
 * @property double $y
 * @property double $z
 * @property integer $rang
 * @property string $title
 * @property string $avatar
 */
class Charecter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charecter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'PlayerName', 'avatar'], 'required'],
            [['account_id', 'MaxHP', 'IdCharMesh', 'PlayerScores', 'scene_ID', 'rang'], 'integer'],
            [['PlayerName'], 'string'],
            [['x', 'y', 'z'], 'number'],
            [['title'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'char_id' => Yii::t('app', 'Char ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'PlayerName' => Yii::t('app', 'Player Name'),
            'MaxHP' => Yii::t('app', 'Max Hp'),
            'IdCharMesh' => Yii::t('app', 'Id Char Mesh'),
            'PlayerScores' => Yii::t('app', 'Player Scores'),
            'scene_ID' => Yii::t('app', 'Scene  ID'),
            'x' => Yii::t('app', 'X'),
            'y' => Yii::t('app', 'Y'),
            'z' => Yii::t('app', 'Z'),
            'rang' => Yii::t('app', 'Rang'),
            'title' => Yii::t('app', 'Title'),
            'avatar' => Yii::t('app', 'Avatar'),
        ];
    }
}
