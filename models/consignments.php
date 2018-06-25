<?php

namespace app\models;
use app\models\products;
use Yii;

/**
 * This is the model class for table "consignments".
 *
 * @property integer $ID_consignment
 * @property integer $actually_in_stock
 * @property string $arrived
 * @property integer $count_in_consignment
 * @property integer $defective_products
 * @property string $parish_price
 * @property string $product_price_in_consignment
 * @property string $shipping_price
 * @property string $storage_life
 * @property integer $Products_ID_product
 * @property integer $WasDel
 * @property integer $Categories_ID_category
 *
 * @property Products $productsIDProduct
 * @property OrdersConsignments[] $ordersConsignments
 * @property Orders[] $ordersIDOrders
 * @property Stories[] $stories
 */
class consignments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consignments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productName'],'safe'], 
            [['arrived', 'storage_life'], 'match', 'pattern' => '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', 'message' => 'Дата в формате ГГГГ-ММ-ДД.'],
            [['actually_in_stock', 'count_in_consignment', 'defective_products', 'Products_ID_product', 'WasDel'], 'integer'],
            [['arrived', 'storage_life'], 'safe'],
            [['parish_price', 'product_price_in_consignment', 'shipping_price'], 'number'],
            [['Products_ID_product'], 'required'],
            [['Products_ID_product'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['Products_ID_product' => 'ID_product']],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_consignment' => 'Id Consignment',
            'actually_in_stock' => 'Actually In Stock',
            'arrived' => 'Arrived',
            'count_in_consignment' => 'Count In Consignment',
            'defective_products' => 'Defective Products',
            'parish_price' => 'Parish Price',
            'product_price_in_consignment' => 'Product Price In Consignment',
            'shipping_price' => 'Цена (руб.)',
            'storage_life' => 'Годен до:',
            'Products_ID_product' => 'Products  Id Product',
            'WasDel' => 'Was Del',
            'productName' => 'Продукт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsIDProduct()
    {       
        return $this->hasOne(Products::className(), ['ID_product' => 'Products_ID_product']);
    }
    public function getProductsIDProductName(){
        return $this->productsIDProduct->name;
    }
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersConsignments()
    {
        return $this->hasMany(OrdersConsignments::className(), ['Consignments_ID_consignment' => 'ID_consignment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersIDOrders()
    {
        return $this->hasMany(Orders::className(), ['ID_order' => 'Orders_ID_order'])->viaTable('orders_consignments', ['Consignments_ID_consignment' => 'ID_consignment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Stories::className(), ['Consignments_ID_consignment' => 'ID_consignment']);
    }
}
