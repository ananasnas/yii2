<?php
namespace app\models;
use yii\db\ActiveRecord;

class menu extends ActiveRecord{
    public static function tableName(){
        return 'menu';
    }
    
}
