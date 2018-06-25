<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_consignments".
 *
 * @property integer $ID_orders_consignments
 * @property integer $Consignments_ID_consignment
 * @property integer $Orders_ID_order
 * @property integer $Products_ID_product
 * @property integer $take_from_consignment
 *
 * @property Consignments $consignmentsIDConsignment
 * @property Orders $ordersIDOrder
 */
class Orders_consignments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_consignments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Consignments_ID_consignment', 'Orders_ID_order', 'Products_ID_product'], 'required'],
            [['Consignments_ID_consignment', 'Orders_ID_order', 'Products_ID_product', 'take_from_consignment'], 'integer'],
            [['Consignments_ID_consignment'], 'exist', 'skipOnError' => true, 'targetClass' => Consignments::className(), 'targetAttribute' => ['Consignments_ID_consignment' => 'ID_consignment']],
            [['Orders_ID_order'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['Orders_ID_order' => 'ID_order']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_orders_consignments' => 'Id Orders Consignments',
            'Consignments_ID_consignment' => 'Consignments  Id Consignment',
            'Orders_ID_order' => 'Orders  Id Order',
            'Products_ID_product' => 'Products  Id Product',
            'take_from_consignment' => 'Take From Consignment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignmentsIDConsignment()
    {
        return $this->hasOne(Consignments::className(), ['ID_consignment' => 'Consignments_ID_consignment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersIDOrder()
    {
        return $this->hasOne(Orders::className(), ['ID_order' => 'Orders_ID_order']);
    }
    public function getproductsIDproduct()
    {       
        return $this->hasOne(Products::className(), ['ID_product' => 'Products_ID_product']);
    }
}
