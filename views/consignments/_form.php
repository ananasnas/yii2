<?php
use app\models\Cars;
use yii\bootstrap\ActiveForm;
use app\models\Products;
use app\models\consignments;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

?>

<?php             
$consignment = consignments::find()->where(['ID_consignment' => $id_])->one();
if (!isset($consignment))
{
    $consignment = new consignments();
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
   $products = Products::find()->select(['ID_product', 'name'])->asArray()->all();
   $array_org = array();
   foreach ($products as $product)
   {
      $array_org[$product['ID_product']] = $product['name'];
   }
   try{
        $param_ = ['options' =>[ array_search($consignment->Products_ID_product, $array_org) => ['Selected' => true]],
                           'style' => 'width: 100%; font-family:Times New Roman' ];
   } catch (Exception $ex) {

   }
?>

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
       
        <p style="margin-top: 10px;">Продукт</p>       
        <?= $form->field($consignment, 'Products_ID_product')->dropDownList($array_org, $param_)->label(false)?>          
        <p style="margin-top: 10px;">Фактическое количество единиц в партии</p>
        <?= $form->field($consignment, 'actually_in_stock')->label(false)?>
        <p style="margin-top: 10px;">Дата прибытия</p>
        <?php
echo DatePicker::widget([
    'model' => $consignment,
    'attribute' => 'arrived',   
    'dateFormat' => 'yyyy-MM-dd',
]);
?>
        <p style="margin-top: 10px;">Количество единиц в партии</p>
        <?= $form->field($consignment, 'count_in_consignment')->label(false)?>
        <p style="margin-top: 10px;">Количество единиц брака</p>
        <?= $form->field($consignment, 'defective_products')->label(false)?>
        <p style="margin-top: 10px;">Цена прихода</p>
        <?= $form->field($consignment, 'parish_price')->label(false)?>
        <p style="margin-top: 10px;">Цена продукта в партии</p>
        <?= $form->field($consignment, 'product_price_in_consignment')->label(false)?>
        <p style="margin-top: 10px;">Отпускная цена</p>
        <?= $form->field($consignment, 'shipping_price')->label(false)?>
        <p style="margin-top: 10px;">Годен до</p>     
       <?php
echo DatePicker::widget([
    'model' => $consignment,
    'attribute' => 'storage_life',   
    'dateFormat' => 'yyyy-MM-dd',
]);
?>
        
             
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