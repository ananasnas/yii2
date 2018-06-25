<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $ID_product
 * @property string $name
 * @property integer $frozen
 * @property string $unit
 * @property integer $Categories_ID_category
 * @property integer $WasDel
 * @property integer $activate
 *
 * @property Consignments[] $consignments
 * @property OrdersProducts[] $ordersProducts
 * @property Orders[] $ordersIDOrders
 * @property Categories $categoriesIDCategory
 * @property Stories[] $stories
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'unit'], 'string'],

            [['name'], 'required'],
            [['frozen', 'Categories_ID_category', 'WasDel', 'activate'], 'integer'],
            [['Categories_ID_category'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['Categories_ID_category' => 'ID_category']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_product' => 'Id Product',
            'name' => 'Наименование',
            'frozen' => 'Frozen',
            'unit' => 'Unit',
            'Categories_ID_category' => 'Categories  Id Category',
            'WasDel' => 'Was Del',
            'activate' => 'Activate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignments()
    {
        return $this->hasMany(Consignments::className(), ['Products_ID_product' => 'ID_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProducts()
    {
        return $this->hasMany(OrdersProducts::className(), ['Products_ID_product' => 'ID_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersIDOrders()
    {
        return $this->hasMany(Orders::className(), ['ID_order' => 'Orders_ID_order'])->viaTable('orders_products', ['Products_ID_product' => 'ID_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesIDCategory()
    {
        return $this->hasOne(Categories::className(), ['ID_category' => 'Categories_ID_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Stories::className(), ['Products_ID_product' => 'ID_product']);
    }
}
