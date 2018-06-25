<?php
use app\models\Products;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php             
$product = Products::find()->where(['ID_product' => $id_])->one();
if (!isset($product))
{
    $product = new Products();
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
    $select_1 = Products::find()->select(['unit'])->distinct()->asArray()->all();
    $array =[];
        foreach ($select_1 as $mas)
            {
                foreach($mas as $el)
                {
                    array_push($array, $el);
                }
            }
            try{
                $param = ['options' =>[ array_search($product->unit, $array) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
            } catch (Exception $ex) {

            }
    
?>

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
        
        <p style="margin-top: 10px;">Название</p>
        <?= $form->field($product, 'name')->label(false)?>
        
        <?= $form->field($product, 'frozen')->checkbox(array('label'=>'Заморожен')); ?>
               
        <p style="margin-top: 10px;">Единицы измерения</p>       
        <?= $form->field($product, 'unit')->dropDownList($array, $param)->label(false)?>
        
        <?= $form->field($product, 'activate')->checkbox(array('label'=>'Введен в продажу')); ?>
        
<?= $form->field($product, 'Categories_ID_category')->hiddenInput()->label(false)?>
        
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