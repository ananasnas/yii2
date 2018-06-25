<?php

namespace app\models;
use app\models\consignments;
use Yii;

/**
 * This is the model class for table "basket".
 *
 * @property integer $ID_basket
 * @property integer $Persons_ID_person
 * @property integer $Consignments_ID_consignement
 * @property integer $Products_ID_product
 * @property integer $take_from_consignment
 *
 * @property Consignments $consignmentsIDConsignement
 * @property Persons $personsIDPerson
 * @property Products $productsIDProduct
 */
class Basket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'basket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Persons_ID_person', 'Consignments_ID_consignement', 'WasDel','Products_ID_product', 'take_from_consignment'], 'integer'],
            [['Consignments_ID_consignement'], 'exist', 'skipOnError' => true, 'targetClass' => Consignments::className(), 'targetAttribute' => ['Consignments_ID_consignement' => 'ID_consignment']],
            [['Persons_ID_person'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['Persons_ID_person' => 'ID_person']],
            [['Products_ID_product'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['Products_ID_product' => 'ID_product']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_basket' => 'Id Basket',
            'Persons_ID_person' => 'Persons  Id Person',
            'Consignments_ID_consignement' => 'Consignments  Id Consignement',
            'Products_ID_product' => 'Products  Id Product',
            'take_from_consignment' => 'Take From Consignment',
            'WasDel'=>'Was Del',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignmentsIDConsignement()
    {
        return $this->hasOne(consignments::className(), ['ID_consignment' => 'Consignments_ID_consignement']);
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
    public function getProductsIDProduct()
    {
        return $this->hasOne(Products::className(), ['ID_product' => 'Products_ID_product']);
    }
}
