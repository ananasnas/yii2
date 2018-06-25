<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $ID_order
 * @property string $comment
 * @property string $date_of_order
 * @property string $delivery_address
 * @property string $delivery_date
 * @property integer $number_of_delivered_units
 * @property string $order_status
 * @property string $prepayment
 * @property integer $Cars_ID_car
 * @property integer $WasDel
 * @property integer $Organizations_ID_organization
 *
 * @property Cars $carsIDCar
 * @property Organizations $organizationsIDOrganization
 * @property OrdersConsignments[] $ordersConsignments
 * @property Consignments[] $consignmentsIDConsignments
 * @property OrdersPersons[] $ordersPersons
 * @property Persons[] $personsIDPeople
 * @property OrdersProducts[] $ordersProducts
 * @property Products[] $productsIDProducts
 * @property Stories[] $stories
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_date', 'date_of_order'], 'match', 'pattern' => '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', 'message' => 'Дата в формате ГГГГ-ММ-ДД.'],
            [['comment', 'delivery_address', 'order_status'], 'string'],
            [['date_of_order', 'delivery_date', 'org'], 'safe'],
            [['delivery_address', 'delivery_date'], 'required'],
            [['number_of_delivered_units', 'Cars_ID_car', 'WasDel', 'Organizations_ID_organization'], 'integer'],
            [['prepayment'], 'number'],
            [['Cars_ID_car'], 'exist', 'skipOnError' => true, 'targetClass' => Cars::className(), 'targetAttribute' => ['Cars_ID_car' => 'ID_car']],
            [['Organizations_ID_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['Organizations_ID_organization' => 'ID_organization']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_order' => 'Id Order',
            'comment' => 'Comment',
            'date_of_order' => 'Date Of Order',
            'delivery_address' => 'Delivery Address',
            'delivery_date' => 'Delivery Date',
            'number_of_delivered_units' => 'Number Of Delivered Units',
            'order_status' => 'Order Status',
            'prepayment' => 'Prepayment',
            'Cars_ID_car' => 'Cars  Id Car',
            'WasDel' => 'Was Del',
            'Organizations_ID_organization' => 'Organizations  Id Organization',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarsIDCar()
    {
        return $this->hasOne(Cars::className(), ['ID_car' => 'Cars_ID_car']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationsIDOrganization()
    {
        return $this->hasOne(Organizations::className(), ['ID_organization' => 'Organizations_ID_organization']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersConsignments()
    {
        return $this->hasMany(OrdersConsignments::className(), ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignmentsIDConsignments()
    {
        return $this->hasMany(Consignments::className(), ['ID_consignment' => 'Consignments_ID_consignment'])->viaTable('orders_consignments', ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPersons()
    {
        return $this->hasMany(OrdersPersons::className(), ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonsIDPeople()
    {
        return $this->hasMany(Persons::className(), ['ID_person' => 'Persons_ID_person'])->viaTable('orders_persons', ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProducts()
    {
        return $this->hasMany(OrdersProducts::className(), ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsIDProducts()
    {
        return $this->hasMany(Products::className(), ['ID_product' => 'Products_ID_product'])->viaTable('orders_products', ['Orders_ID_order' => 'ID_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Stories::className(), ['Orders_ID_order' => 'ID_order']);
    }
}
