<?php
use app\models\Orders;
use yii\bootstrap\ActiveForm;
use app\models\persons;
use yii\helpers\Html;
use app\models\Basket;
use yii\widgets\Pjax;
?>

<?php Pjax::begin(['id'=>'my-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>            
       
        <p style="margin-top: 10px;">Извините, в партии недостаточно единиц товара.</p>                   

        <?php ActiveForm::end(); ?>      
<?php Pjax::end(); ?>  