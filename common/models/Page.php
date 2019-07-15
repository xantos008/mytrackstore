<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 * @property string $content
 * @property integer $header_position
 * @property string $type
 * @property string $file
 * @property string $title_browser
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['published', 'header_position'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'alias', 'type', 'file', 'title_browser'], 'string', 'max' => 255],
            [['meta_keywords'], 'string', 'max' => 200],
            [['meta_description'], 'string', 'max' => 160],
            [['alias'], 'unique'],
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
            'alias' => Yii::t('app', 'Alias'),
            'published' => Yii::t('app', 'Published'),
            'content' => Yii::t('app', 'Content'),
            'header_position' => Yii::t('app', 'Header Position'),
            'type' => Yii::t('app', 'Type'),
            'file' => Yii::t('app', 'File'),
            'title_browser' => Yii::t('app', 'Title Browser'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
