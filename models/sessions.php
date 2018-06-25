<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sessions".
 *
 * @property integer $ID_session
 * @property string $text
 * @property integer $IP_person
 * @property string $valid_start
 * @property string $valid_finish
 *
 * @property Persons[] $persons
 */
class sessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sessions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'referrer', 'cookie'], 'string'],
            [['IP_person'], 'string'],
            [['valid_start', 'valid_finish'], 'required'],
            [['valid_start', 'valid_finish'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_session' => 'Id Session',
            'text' => 'Text',
            'IP_person' => 'Ip Person',
            'valid_start' => 'Valid Start',
            'valid_finish' => 'Valid Finish',
            'referrer'=>'Referrer',
            'cookie'=>'Cookie',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::className(), ['Sessions_ID_session' => 'ID_session']);
    }
}
