<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "premiumndownloads".
 *
 * @property integer $id
 * @property string $type
 * @property string $date
 */
class Premiumndownloads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'premiumndownloads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'date'], 'required'],
            [['type'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
