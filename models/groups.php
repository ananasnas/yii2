<?php
namespace app\models;
use yii\db\ActiveRecord;

class groups extends ActiveRecord{
    public static function tableName(){
        return 'groups';
    }
     // первое - с связываемой(menu), второе на какое поле ссылается id_menu  в данной таблице
    public function getMenu(){
           return $this->hasMany(menu::className(), ['ID_menu' => 'ID_menu'])
            ->viaTable('groups_menu', ['ID_group' => 'ID_group']);
    }
}

