<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property int $sliderposition
 * @property string $sliderpath
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sliderposition'], 'integer'],
            [['sliderpath', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sliderposition' => Yii::t('app', 'Sliderposition'),
            'sliderpath' => Yii::t('app', 'Sliderpath'),
            'link' => Yii::t('app', 'Link'),
        ];
    }
}
