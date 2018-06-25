<?php
use app\models\Cars;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\models\Orders;
use app\models\organizations;
use app\models\Orders_consignments;
use app\models\Orders_consignmentsSearch;
use yii\jui\DatePicker;
use yii\grid\GridView;
?>

<?php             
$order = Orders::find()->where(['ID_order' => $id_])->one();
?> 
  
<?php
    $id_group = 20;        
            try{
                $identity = Yii::$app->user->identity;
                $id_group = $identity->Groups_ID_group;
              }
      catch (Exception $e){       
    }
?>   

<?php 
   $organizations = organizations::find()->select(['ID_organization', 'name'])->asArray()->all();
   $array_org = array();
   foreach ($organizations as $organization)
   {
      $array_org[$organization['ID_organization']] = $organization['name'];
   }
   try{
        $param_ = ['options' =>[ array_search($order->Organizations_ID_organization, $array_org) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
   } catch (Exception $ex) {

   }
?>

<?php 
   $cars = Cars::find()->select(['ID_car', 'number'])->asArray()->all();
   $array_org_ = array();
   foreach ($cars as $car)
   {
      $array_org_[$car['ID_car']] = $car['number'];
   }
   try{
        $param = ['options' =>[ array_search($order->Cars_ID_car, $array_org_) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
   } catch (Exception $ex) {

   }
?>

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
       
        <p style="margin-top: 10px;">Дата заказа</p>
       
   <?php
echo DatePicker::widget([
    'model' => $order,
    'attribute' => 'date_of_order',   
    'dateFormat' => 'dd.MM.yyyy',
]);
?>
       
        <p style="margin-top: 10px;">Дата доставки</p>      
               <?php
echo DatePicker::widget([
    'model' => $order,
    'attribute' => 'delivery_date',   
    'dateFormat' => 'dd.MM.yyyy',
]);
?>
        
        <p style="margin-top: 10px;">Адрес доставки</p>
        <?= $form->field($order, 'delivery_address')->label(false)?>
        
        <p style="margin-top: 10px;">Комментарий</p>
        <?= $form->field($order, 'comment')->label(false)?>     
        
        <p style="margin-top: 10px;">Предоплата</p>
        <?= $form->field($order, 'prepayment')->label(false)?>  
        
        <p style="margin-top: 10px;">Товары</p>

<?php
$searchModel = new Orders_consignmentsSearch();
$dataProvider = $searchModel->search($order->ID_order);
?>       

<?php Pjax::begin(); ?>
<?= GridView::widget([
            'dataProvider' => $dataProvider,  
          
            'id'=>'usong-grid',
            'tableOptions' => [
                'class' => 'table table-hover table-condensed table-bordered mytab_',
               ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

              [
                    'attribute' => 'productName',
                    'label' => 'Продукт',
                    'value' => function($model) {
                             return $model->productsIDproduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                    }
                ] ,
                
           
                            ],                               
        ]);
?>
<?php Pjax::end(); ?>
        
        <p style="margin-top: 10px;">Количество доставленных единиц продукции</p>
        <?= $form->field($order, 'number_of_delivered_units')->label(false)?>  
         
        <p style="margin-top: 10px;">Организация</p>       
        <?= $form->field($order, 'Organizations_ID_organization')->dropDownList($array_org, $param_)->label(false)?> 
        
        <p style="margin-top: 10px;">Автомобиль для доставки</p>       
        <?= $form->field($order, 'Cars_ID_car')->dropDownList($array_org_, $param)->label(false)?>    
        
        
         
        
        <?= $form->field($order, 'order_status')->checkbox(array('label'=>'Заказ закрыт')); ?>
        
        
        <?php if($flag==1):?>
        <span class="vvt panel pi" style="margin-top: 0%; width: 100px;">
          <?= Html::submitButton('Сохранить',['class'=>'v panel pi', 'style'=>'width: 150px'])?>
        </span>
        

        <span class="vvt panel pi" style="margin-top: 0%; width: 100px; float: right; margin-right: 12%;">
            <button type="button" class="btn btn-outline v panel pi" style="width: 150px;" data-dismiss="modal">Закрыть</button>    
        </span>
        <?php endif;?>   
        <?php ActiveForm::end(); ?>      
<?php Pjax::end(); ?>  