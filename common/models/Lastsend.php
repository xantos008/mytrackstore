<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lastsend".
 *
 * @property int $id
 * @property string $lastsend
 */
class Lastsend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lastsend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lastsend'], 'required'],
            [['lastsend'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lastsend' => Yii::t('app', 'Lastsend'),
        ];
    }
}
