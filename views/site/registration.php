<?php
use yii\widgets\Menu;
use app\models\persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Регистрация';

//регистрация только для контактных лиц
//всех остальных менеджер добавляет сам
//контактные лица м.б. добавлены и менеджером

?>
<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu" style="font-size: 12pt;"/>                                   
      <?php
      $person_ = new persons();
$items = getItems('20');
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
<h1 style="margin-top:3%;">Регистрация</h1>
<p style="text-align: center; font-size:14pt; margin-top: 30px; margin-bottom: 30px;">Регистрация предназначена только для контактных лиц организаций.<p>
<p style="text-align: center; font-size:14pt; margin-top: 30px; margin-bottom: 30px;">Пожалуйста, введите свои данные:<p>
    <div style="display:flex; justify-content:center; ">
    <?php $form = ActiveForm::begin(['id'=>'reg'])?>
      
        <p>Фамилия</p>
        <?= $form->field($person_, 'surname')->label(false)?>
        <p style="margin-top: 10px;">Имя</p>
        <?= $form->field($person_, 'name')->label(false)?>
        <p style="margin-top: 10px;">Отчество</p>
        <?= $form->field($person_, 'middle_name')->label(false)?>
        <p style="margin-top: 10px;">Логин</p>
        <?= $form->field($person_, 'login')->label(false)?>
        <p style="margin-top: 10px;">Пароль</p>
        <?= $form->field($person_, 'password')->passwordInput()->label(false)?>
        <p style="margin-top: 10px;">E-mail</p>
        <?= $form->field($person_, 'mail')->label(false)?>
        <p style="margin-top: 10px;">Телефон</p>
        <?= $form->field($person_, 'tel')->label(false)?>
        <p style="margin-top: 10px;">Организация</p>
    <?php
        $select_1 = \app\models\organizations::find()->select(['ID_organization', 'name'])->asArray()->all();
        $array =array();
        
        foreach ($select_1 as $mas)
            {
                $key = $mas['ID_organization'];
                $value = $mas['name'];
                $array[$key]=$value;           
            }      
            
    ?>
        <?= $form->field($person_, 'Organizations_ID_organization')->dropDownList($array, ['style' => 'width: 100%; font-family:Times New Roman'])->label(false)?>
   
            <?php $form = ActiveForm::end()?>    
    </div>
   
    <div class="v panel pi" >
        <a href=""><?= Html::submitButton('Зарегистрироваться', ['class'=>'v panel pi', 'form'=>'reg'])?></a>
    </div>
</article>