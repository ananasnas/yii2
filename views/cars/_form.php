<?php
use app\models\Cars;
use yii\bootstrap\ActiveForm;
use app\models\persons;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<?php             
$car = Cars::find()->where(['ID_car' => $id_])->one();
if (!isset($car))
{
    $car = new Cars();
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

<?php 
   $persons = persons::find()->select(['ID_person', 'surname'])->asArray()->all();
   $array_org = array();
   foreach ($persons as $person)
   {
      $array_org[$person['ID_person']] = $person['surname'];
   }
   try{
        $param_ = ['options' =>[ array_search($car->Persons_ID_person, $array_org) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
   } catch (Exception $ex) {

   }
?>

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
       
        <p style="margin-top: 10px;">Модель</p>
        <?= $form->field($car, 'name')->label(false)?>
        
        <p style="margin-top: 10px;">Номер</p>
        <?= $form->field($car, 'number')->label(false)?>
         
        <?= $form->field($car, 'freezer')->checkbox(array('label'=>'С морозильной камерой')); ?>
        
        <?= $form->field($car, 'freight')->checkbox(array('label'=>'Грузовая')); ?>
        
         <p style="margin-top: 10px;">Не доступен с:</p>
            <?php
echo DatePicker::widget([
    'model' => $car,
    'attribute' => 'not_availble_start',   
    'dateFormat' => 'dd.MM.yyyy',
]);
?>
            
            <p style="margin-top: 10px;">Не доступен по:</p>
          <?php
echo DatePicker::widget([
    'model' => $car,
    'attribute' => 'not_availble_finish',   
    'dateFormat' => 'dd.MM.yyyy',
]);
?>
        
         <p style="margin-top: 10px;">Водитель</p>       
            <?= $form->field($car, 'Persons_ID_person')->dropDownList($array_org, $param_)->label(false)?>    
        
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