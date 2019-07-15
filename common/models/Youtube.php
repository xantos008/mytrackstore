<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "youtube".
 *
 * @property int $id
 * @property string $link
 */
class Youtube extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'youtube';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'link' => Yii::t('app', 'Link'),
        ];
    }
}
