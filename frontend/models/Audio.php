<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audio".
 *
 * @property int $id
 * @property int $category
 * @property string $filename
 * @property string $path
 * @property int $views
 * @property string $adddate
 */
class Audio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'filename', 'path', 'adddate'], 'required'],
            [['category', 'views'], 'integer'],
            [['adddate'], 'safe'],
            [['filename', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'filename' => Yii::t('app', 'Filename'),
            'path' => Yii::t('app', 'Path'),
            'views' => Yii::t('app', 'Views'),
            'adddate' => Yii::t('app', 'Adddate'),
        ];
    }
}
