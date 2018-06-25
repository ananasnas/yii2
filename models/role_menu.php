<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_menu".
 *
 * @property integer $item_name
 * @property integer $ID_menu
 */
class role_menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'ID_menu'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'ID_menu' => 'Id Menu',
        ];
    }
}
