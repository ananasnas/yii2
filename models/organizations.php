<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizations".
 *
 * @property integer $ID_organization
 * @property string $name
 * @property string $address
 * @property string $bank_account
 * @property string $discount
 * @property string $inn
 * @property string $comment
 * @property string $ownership
 * @property integer $WasDel
 *
 * @property Orders[] $orders
 * @property Persons[] $persons
 * @property Stories[] $stories
 */
class organizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organizations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'bank_account', 'inn', 'ownership'], 'required'],
            [['name', 'address', 'bank_account', 'inn', 'comment', 'ownership'], 'string'],
            [['discount'], 'number'],
            [['WasDel'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_organization' => 'Id Organization',
            'name' => 'Наименование',
            'address' => 'Адрес',
            'bank_account' => 'Счет',
            'discount' => 'Скидка',
            'inn' => 'ИНН',
            'comment' => 'Комментарий',
            'ownership' => 'Вид',
            'WasDel' => 'Was Del',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['Organizations_ID_organization' => 'ID_organization']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::className(), ['Organizations_ID_organization' => 'ID_organization']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Stories::className(), ['Organizations_ID_organization' => 'ID_organization']);
    }
}
