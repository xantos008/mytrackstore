<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $category
 * @property string $content
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'content'], 'required'],
            [['category', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'content' => Yii::t('app', 'Content'),
        ];
    }
}
