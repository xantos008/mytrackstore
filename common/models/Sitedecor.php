<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sitedecor".
 *
 * @property int $id
 * @property string $background
 */
class Sitedecor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sitedecor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['background'], 'required'],
            [['background'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'background' => Yii::t('app', 'Background'),
        ];
    }
}
