<?php
use app\models\Orders;
use yii\bootstrap\ActiveForm;
use app\models\persons;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
?>

<?php             
$order = orders::find()->where(['ID_order' => $id_])->one();
if (!isset($order))
{
   $order = new Orders();
}
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

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
       
        <p style="margin-top: 10px;">Дата доставки</p>  
        <?php
echo DatePicker::widget([
    'model' => $order,
    'attribute' => 'delivery_date',   
    'dateFormat' => 'yyyy-MM-dd',
]);
?>
        
        
        <p style="margin-top: 10px;">Адрес доставки</p>
        <?= $form->field($order, 'delivery_address')->label(false)?>
        
        <p style="margin-top: 10px;">Предоплата</p>
        <?= $form->field($order, 'prepayment')->label(false)?>        
      
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