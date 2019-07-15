<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "map".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $PatchMesh
 * @property string $picture
 */
class Maps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'picture'], 'required'],
            [['Id'], 'integer'],
            [['Name', 'PatchMesh', 'picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Name'),
            'PatchMesh' => Yii::t('app', 'Patch Mesh'),
            'picture' => Yii::t('app', 'Picture'),
        ];
    }
}
