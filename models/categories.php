<?php

namespace app\models;
use yii\db\ActiveRecord;

class categories extends ActiveRecord{
   public static function tableName(){
       return 'categories';
   }
   public function getProducts(){
       return $this->hasMany(Product::className(), ['Categories_ID_category' => 'ID_category']);
   }
}
