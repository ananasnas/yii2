<?php
use app\models\persons;
use yii\bootstrap\ActiveForm;
use app\models\organizations;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php             
$organization = organizations::find()->where(['ID_organization' => $id_])->one();
if (!isset($organization))
{
    $organization = new organizations();
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
        
        <p style="margin-top: 10px;">Наименование</p>
        <?= $form->field($organization, 'name')->label(false)?>
        
        <p style="margin-top: 10px;">Адрес</p>
        <?= $form->field($organization, 'address')->label(false)?>
        
        <p style="margin-top: 10px;">Банковский счет</p>
        <?= $form->field($organization, 'bank_account')->label(false)?>
        
        <p style="margin-top: 10px;">Скидка</p>
        <?= $form->field($organization, 'discount')->label(false)?>
        
        <p style="margin-top: 10px;">ИНН</p>
        <?= $form->field($organization, 'inn')->label(false)?>
        
        <p style="margin-top: 10px;">Комментарий</p>
        <?= $form->field($organization, 'comment')->label(false)?>
        
        <p style="margin-top: 10px;">Вид</p>
        <?= $form->field($organization, 'ownership')->label(false)?>
        
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