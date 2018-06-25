<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property integer $ID_car
 * @property integer $freezer
 * @property integer $freight
 * @property string $not_availble_start
 * @property string $not_availble_finish
 * @property string $number
 * @property string $name
 * @property integer $WasDel
 * @property integer $Persons_ID_person
 *
 * @property Persons $personsIDPerson
 * @property Orders[] $orders
 * @property Stories[] $stories
 */
class Cars extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'], 'required'], 
            [['not_availble_start', 'not_availble_finish'], 'match', 'pattern' => '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', 'message' => 'Дата в формате ГГГГ-ММ-ДД.'],
            [['freezer', 'freight', 'WasDel', 'Persons_ID_person'], 'integer'],
            [['not_availble_start', 'not_availble_finish'], 'safe'],                           
            [['number', 'name'], 'string'],
            [['Persons_ID_person'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['Persons_ID_person' => 'ID_person']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_car' => 'Id Car',
            'freezer' => 'Freezer',
            'freight' => 'Freight',
            'not_availble_start' => 'Not Availble Start',
            'not_availble_finish' => 'Not Availble Finish',
            'number' => 'Number',
            'name' => 'Name',
            'WasDel' => 'Was Del',
            'Persons_ID_person' => 'Persons  Id Person',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonsIDPerson()
    {
        return $this->hasOne(Persons::className(), ['ID_person' => 'Persons_ID_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['Cars_ID_car' => 'ID_car']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Stories::className(), ['Cars_ID_car' => 'ID_car']);
    }
}
