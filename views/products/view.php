<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\categories;
use app\models\products;
use app\models\consignments;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = "Редактировать продукт";   
?>
<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu">                
                 
     <?php
$items;

if(!\Yii::$app->user->isGuest){
    $identity = Yii::$app->user->identity;
    $items = getMenu($identity);  
}

echo Menu::widget([
    'items' => $items,
    'options' => [
    ],   
    'itemOptions' => [    
        'tag' => false
    ]
]);
?>      
            </nav> 
        </header>			
</div>
<article class="content">
    <div class="v panel pi" style="font-size:110%; margin-left: -16px;margin-bottom: 0px; border: 0px; border-radius: 0px;  box-shadow: 0 0 0 0; background-color: #FFFFF0;">
        <a href="<?=\yii\helpers\Url::to(['categories/view', 'ID_category' => $product->Categories_ID_category])?>"><button style="width:230px">Назад</button></a>
    </div>
    <div class="v panel pi" style="font-size:110%; margin-bottom: 0px; border: 0px; border-radius: 0px;  box-shadow: 0 0 0 0; background-color: #FFFFF0;">
        <a href=""><?= Html::submitButton('Сохранить изменения', ['class'=>'v panel pi', 'form'=>'save_'])?></a>
    </div>
    <h1 style="margin-bottom: 20px;">Редактировать продукт</h1>
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
<!--размеры--> <?php $form = ActiveForm::begin(['id'=>'add_'])?>
        <p>Название</p>
        <?= $form->field($product, 'name')->label(false)?>
        <p style="margin-top: 10px;">Единицы измерения</p>
        <?= $form->field($product, 'unit')->dropDownList($array, ['style' => 'width: 100%; font-family:Times New Roman'])->label(false)?>
        <p style="margin-top: 10px;">Состояние</p>
        <?= $form->field($product, 'frozen')->checkbox()?>
        <?php $form = ActiveForm::end()?>
    </div>
</article>

