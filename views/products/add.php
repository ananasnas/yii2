<?php
use yii\widgets\Menu;
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use app\models\products;
$this->title = "Добавить продукт";   
?>

<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu">                
                 
     <?php
$items = getItems(10);
echo Menu::widget([
    'items' => $items,
    'options' => [
    ],   
    'itemOptions' => [    
        'tag' => false
    ]
]);?>      
            </nav> 
        </header>			
</div>
<article class="content">
   <div class="vvt panel pi">
        <a href="<?=\yii\helpers\Url::to(['categories/view', 'ID_category' => $ID_category])?>"><button style="width:230px">Назад</button></a>
    </div>
    <div class="vvt panel pi" style="margin-left: 3%;">
        <a href=""><?= Html::submitButton('Добавить', ['class'=>'v panel pi', 'form'=>'add_'])?></a>
    </div>

    <h1 style="margin-bottom: 20px;">Добавить продукт</h1>
    <?php
        $select_1 = products::find()->select(['unit'])->distinct()->asArray()->all();
        $array =[];
        foreach ($select_1 as $mas)
            {
                foreach($mas as $el)
                {
                    array_push($array, $el);
                }
            }           
    ?>
    <div style="display:flex; justify-content:center">
        <?php $form = ActiveForm::begin(['id'=>'add_'])?>
        <p>Название</p>
        <?= $form->field($product, 'name')->label(false)?>
        <p style="margin-top: 10px;">Единицы измерения</p>
        <?= $form->field($product, 'unit')->dropDownList($array, ['style' => 'width: 100%; font-family:Times New Roman'])->label(false)?>
        <p style="margin-top: 10px;">Состояние</p>
        <?= $form->field($product, 'frozen')->checkbox()?>
        <?php $form = ActiveForm::end()?>
    </div>
</article>

