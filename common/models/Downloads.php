<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "downloads".
 *
 * @property int $id
 * @property int $track_id
 * @property int $dj_id
 * @property string $date
 */
class Downloads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'downloads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'dj_id', 'date'], 'required'],
            [['track_id', 'dj_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'track_id' => Yii::t('app', 'Track ID'),
            'dj_id' => Yii::t('app', 'Dj ID'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
