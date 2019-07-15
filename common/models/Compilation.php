<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "compilation".
 *
 * @property int $id
 * @property string $name
 * @property string $picture
 * @property string $description
 * @property string $audio
 * @property string $buttontext
 * @property string $metatitle
 * @property string $metadescription
 * @property string $metakeywords
 */
class Compilation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compilation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'picture', 'description', 'audio', 'buttontext', 'metatitle', 'metadescription', 'metakeywords', 'url'], 'required'],
            [['description'], 'string'],
            [['name', 'picture', 'audio', 'buttontext', 'metatitle', 'metadescription','url'], 'string', 'max' => 255],
            [['metakeywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'picture' => Yii::t('app', 'Picture'),
            'description' => Yii::t('app', 'Description'),
            'audio' => Yii::t('app', 'Audio'),
            'buttontext' => Yii::t('app', 'Buttontext'),
            'metatitle' => Yii::t('app', 'Metatitle'),
            'metadescription' => Yii::t('app', 'Metadescription'),
            'metakeywords' => Yii::t('app', 'Metakeywords'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
