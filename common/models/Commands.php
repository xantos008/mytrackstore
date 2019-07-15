<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commands".
 *
 * @property integer $id
 * @property string $name
 * @property integer $capitan
 * @property string $description
 * @property string $password
 */
class Commands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'capitan', 'description', 'password'], 'required'],
            [['capitan'], 'integer'],
            [['name', 'description', 'password', 'tournament'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'capitan' => Yii::t('app', 'Capitan'),
            'description' => Yii::t('app', 'Description'),
            'password' => Yii::t('app', 'Password'),
            'tournament' => Yii::t('app', 'Tournament'),
        ];
    }
}
