<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "tournament".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $datestart
 * @property string $dateend
 * @property integer $pricefond
 * @property integer $members
 */
class Tournament extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	 
	 
    public static function tableName()
    {
        return 'tournament';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'name', 'pricefond', 'members'], 'required'],
            [['status', 'members', 'position'], 'integer'],
            [['datestart', 'dateend'], 'safe'],
            [['name', 'maps', 'type', 'fon', 'type_money', 'startmoney', 'pricefond'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'datestart' => Yii::t('app', 'Datestart'),
            'dateend' => Yii::t('app', 'Dateend'),
            'pricefond' => Yii::t('app', 'Pricefond'),
            'members' => Yii::t('app', 'Members'),
			'maps' => Yii::t('app', 'Maps'),
			'type' => Yii::t('app', 'Tournament type'),
			'type_money' => Yii::t('app', 'Joining type'),
			'fon' => Yii::t('app', 'Background'),
			'position' => Yii::t('app', 'Position'),
			'startmoney' => Yii::t('app', 'Start money'),
        ];
    }
}
