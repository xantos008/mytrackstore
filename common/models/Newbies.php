<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pukovodsto".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $header_position
 * @property integer $parentId
 * @property string $file
 * @property string $title_browser
 * @property string $meta_keywords
 * @property string $meta_description
 */
class Newbies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pukovodsto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'file', 'title_browser', 'meta_keywords', 'meta_description'], 'required'],
            [['header_position', 'parentId'], 'integer'],
            [['title', 'content', 'file', 'title_browser', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'header_position' => Yii::t('app', 'Header Position'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'file' => Yii::t('app', 'File'),
            'title_browser' => Yii::t('app', 'Title Browser'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
        ];
    }
}
