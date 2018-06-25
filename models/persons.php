<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property integer $ID_person
 * @property string $surname
 * @property string $name
 * @property string $middle_name
 * @property string $login
 * @property string $password
 * @property string $mail
 * @property string $tel
 * @property string $not_availble_start
 * @property string $not_availble_finish
 * @property integer $count_of_open_orders
 * @property integer $Organizations_ID_organization
 * @property integer $Groups_ID_group
 * @property integer $Sessions_ID_session
 * @property string $position
 * @property integer $WasDel
 * @property string $cookie
 * @property string $salt
 * @property string $pass
 *
 * @property Basket[] $baskets
 * @property Cars[] $cars
 * @property OrdersPersons[] $ordersPersons
 * @property Orders[] $ordersIDOrders
 * @property Groups $groupsIDGroup
 * @property Organizations $organizationsIDOrganization
 * @property Sessions $sessionsIDSession
 */
class persons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname', 'name', 'middle_name', 'login', 'password', 'mail', 'tel', 'position', 'cookie', 'salt', 'pass'], 'string'],
            [['not_availble_start', 'not_availble_finish'], 'safe'],
            [['count_of_open_orders', 'Organizations_ID_organization', 'Groups_ID_group', 'Sessions_ID_session', 'WasDel'], 'integer'],
            [['Groups_ID_group'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['Groups_ID_group' => 'ID_group']],
            [['Organizations_ID_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['Organizations_ID_organization' => 'ID_organization']],
            [['Sessions_ID_session'], 'exist', 'skipOnError' => true, 'targetClass' => Sessions::className(), 'targetAttribute' => ['Sessions_ID_session' => 'ID_session']],
       [['surname', 'name', 'middle_name', 'mail', 'tel'], 'required'],
            [['surname', 'name', 'middle_name'], 'match', 'pattern' => '/^[А-я\s]+$/u', 'message' => 'Поле должно быть заполнено кириллицей.'],
            ['mail', 'email', 'message' => 'Поле должно быть заполнено в формате "name@gmail.com"'],
            ['tel','number', 'message' => 'Поле должно быть заполнено строкой цифр без пробелов.'],
            [['surname', 'name', 'middle_name', 'login', 'password', 'mail', 'tel', 'position'], 'string' , 'message' => 'Поле не должно содержать '],
            [['not_availble_start', 'not_availble_finish'], 'safe'],
            [['count_of_open_orders', 'Organizations_ID_organization', 'Groups_ID_group', 'Sessions_ID_session', 'WasDel'], 'integer'],
            [['Groups_ID_group'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['Groups_ID_group' => 'ID_group']],
            [['Organizations_ID_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['Organizations_ID_organization' => 'ID_organization']],
            [['Sessions_ID_session'], 'exist', 'skipOnError' => true, 'targetClass' => Sessions::className(), 'targetAttribute' => ['Sessions_ID_session' => 'ID_session']],
            
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'middle_name' => 'Отчество',           
            'mail' => 'Mail',
            'tel' => 'Телефон',
            'not_availble_start' => 'Не доступен с:',
            'not_availble_finish' => 'Не доступен по:',
            'count_of_open_orders' => 'Количество открытых заказов',        
            'position' => 'Должность',
            'Groups_ID_group'  => 'ID_group',
            'salt'  => 'Salt',
            'pass'  => 'Pass',
          
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaskets()
    {
        return $this->hasMany(Basket::className(), ['Persons_ID_person' => 'ID_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Cars::className(), ['Persons_ID_person' => 'ID_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPersons()
    {
        return $this->hasMany(OrdersPersons::className(), ['Persons_ID_person' => 'ID_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersIDOrders()
    {
        return $this->hasMany(Orders::className(), ['ID_order' => 'Orders_ID_order'])->viaTable('orders_persons', ['Persons_ID_person' => 'ID_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupsIDGroup()
    {
        return $this->hasOne(Groups::className(), ['ID_group' => 'Groups_ID_group']);
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
    public function getSessionsIDSession()
    {
        return $this->hasOne(Sessions::className(), ['ID_session' => 'Sessions_ID_session']);
    }
}
