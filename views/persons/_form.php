<?php
use app\models\persons;
use yii\bootstrap\ActiveForm;
use app\models\organizations;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<?php             
$person = persons::find()->where(['ID_person' => $id_])->one();
if (!isset($person))
{
    $person = new persons();
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
    $select_1 = persons::find()->select(['position'])->distinct()->asArray()->all();
    $array =[];
        foreach ($select_1 as $mas)
            {
                foreach($mas as $el)
                {
                    array_push($array, $el);
                }
            }
            try{
                $param = ['options' =>[ array_search($person->position, $array) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
            } catch (Exception $ex) {

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
        $param_ = ['options' =>[ array_search($person->Organizations_ID_organization, $array_org) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
   } catch (Exception $ex) {

   }
?>

<?php Pjax::begin(['enablePushState' => false]); ?>
<?php $form = ActiveForm::begin(['id'=>'_form']); ?> 
<p style="margin-top: 10px;">Фамилия</p>
        <?= $form->field($person, 'surname')->label(false)?> 
        <p style="margin-top: 10px;">Имя</p>
        <?= $form->field($person, 'name')->label(false)?>
        <p style="margin-top: 10px;">Отчество</p>
        <?= $form->field($person, 'middle_name')->label(false)?>
        <p style="margin-top: 10px;">E-mail</p>
        <?= $form->field($person, 'mail')->label(false)?>
        <p style="margin-top: 10px;">Телефон</p>
        <?= $form->field($person, 'tel')->label(false)?>      
                
        <p style="margin-top: 10px;">Логин</p>
        <?= $form->field($person, 'login')->label(false)?>       
        
        <p style="margin-top: 10px;">Пароль</p>
        <?= $form->field($person, 'pass')->label(false)?>
        <?= $form->field($person, 'password')->hiddenInput()->label(false)?>
        <?php if(Yii::$app->user->can('managementEmployees')):?>
            <?php
echo DatePicker::widget([
    'model' => $person,
    'attribute' => 'not_availble_start',   
    'dateFormat' => 'dd.MM.yyyy',
]);
?>
          
            <p style="margin-top: 10px;">Не доступен по:</p>
<?php
echo DatePicker::widget([
    'model' => $person,
    'attribute' => 'not_availble_finish',  
    'dateFormat' => 'dd.MM.yyyy',
]);
?>     
          
            <p style="margin-top: 10px;">Количество открытых заказов</p>
            <?= $form->field($person, 'count_of_open_orders')->label(false)?>
        <?php endif;?>
        <?php if(Yii::$app->user->can('managementContactPersons')):?>
            <p style="margin-top: 10px;">Организация</p>       
            <?= $form->field($person, 'Organizations_ID_organization')->dropDownList($array_org, $param_)->label(false)?>    
        <?php endif;?>
                    
        <p style="margin-top: 10px;">Должность</p>       
        <?= $form->field($person, 'position')->dropDownList($array, $param)->label(false)?>
        
<?= $form->field($person, 'Groups_ID_group')->hiddenInput()->label(false)?>
       
        <?php if($flag==1):?>
        <span class="vvt panel pi" style="margin-top: 0%; width: 100px;">
          <?= Html::SubmitButton('Сохранить',['class'=>'v panel pi', 'style'=>'width: 150px'])?>
        </span>
        
        <span class="vvt panel pi" style="margin-top: 0%; width: 100px; float: right; margin-right: 12%;">
            <button type="button" class="btn btn-outline v panel pi" style="width: 150px;" data-dismiss="modal">Закрыть</button>    
        </span>
        <?php endif;?>   
        <?php ActiveForm::end(); ?>      
<?php Pjax::end(); ?>